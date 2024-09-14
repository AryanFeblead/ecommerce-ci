<?php

namespace App\Controllers;

use App\Models\BillModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\CardModel;
use App\Models\CustomerModel;

class Checkout extends BaseController
{
    public function index()
    {
        $session = \Config\Services::session();
        $cartItems = $session->get('cart_item');

        $data = [
            'cartItems' => $cartItems,
            'totalAmount' => 0,
        ];

        if (!empty($cartItems)) {
            $totalAmount = 0;

            foreach ($cartItems as $item) {
                $itemTotal = $item['prod_price'] * $item['prod_quantity'];
                $totalAmount += $itemTotal;
            }
            $data['totalAmount'] = number_format($totalAmount, 2);
        }
        echo view('common/header');
        echo view('ecommerce/checkout', $data);
        echo view('common/footer');
    }
    public function COD()
    {
        $session = session();
        $cartItem = $session->get('cart_item');
        $customerId = $session->get('customer_id');

        if (!$cartItem || !$customerId) {
            return $this->response->setJSON(["status" => "error", "message" => "Cart is empty or user is not logged in."]);
        }

        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON(["status" => "error", "message" => "Invalid request method."]);
        }

        $orderModel = new OrderModel();
        $billModel = new BillModel();

        $orderId = $orderModel->getNextOrderId();


        $formData = $this->request->getPost();

        $orderModel->insertOrder($orderId, $cartItem, $customerId);

        $billModel->insertBill($formData, $orderId, $this->calculateTotalAmount($cartItem), $customerId);

        $session->remove('cart_item');

        return $this->response->setJSON(["status" => "success", "message" => "Order placed successfully"]);
    }
    private function calculateTotalAmount($cartItem)
    {
        $totalAmount = 0;
        foreach ($cartItem as $item) {
            $itemTotal = $item['prod_price'] * $item['prod_quantity'];
            $totalAmount += $itemTotal;
        }
        return number_format($totalAmount, 2);
    }
    public function payment_stripe()
    {
        if ($this->request->getPost('tokenId')) {
            // Load the Stripe PHP library
            require_once(APPPATH . 'libraries/stripe-php/init.php');

            // Stripe secret key
            $stripeSecret = 'sk_test_51Pp54dGC4teGxUj2mgtXt2nvF0T8sNlvVSqtso5NpwxQpqH4N5K1fZSy0vmeyW7bhnBTiNBydUhuovhPRhVZLxR3009z8D1NOm';

            // Set the Stripe API key
            \Stripe\Stripe::setApiKey($stripeSecret);

            // Get the payment token ID submitted by the form
            $token = $this->request->getPost('tokenId');
            $amount = $this->request->getPost('amount');

            try {
                // Charge the user's card
                $charge = \Stripe\Charge::create(array(
                    "amount" => $amount,
                    "currency" => "usd",
                    "description" => "Stripe integration in CodeIgniter",
                    "source" => $token,
                ));

                // Respond with success and charge details
                $data = array('success' => true, 'data' => $charge);
                echo json_encode($data);
            } catch (\Exception $e) {
                // Handle errors
                $data = array('success' => false, 'error' => $e->getMessage());
                echo json_encode($data);
            }
        } else {
            // Handle the case where tokenId is not provided
            $data = array('success' => false, 'error' => 'Token ID is missing');
            echo json_encode($data);
        }
    }
    public function success()
    {
        $paymentID = $this->request->getGet('paymentid');
        $orderID = $this->request->getGet('orderid');
        $amount = $this->request->getGet('amount');

        $session = session();
        if ($session->has('customer_id')) {
            $customerId = $session->get('customer_id');

            // Load the Payment model
            $paymentModel = new PaymentModel();

            // Insert payment into card_payment table
            $paymentData = [
                'order_id' => $orderID,
                'payer_id' => $customerId,
                'payment_id' => $paymentID,
                'amount' => $amount,
                'currency' => 'USD',
                'status' => 'Success'
            ];

            $paymentModel->insert($paymentData);

            // Fetch payment details
            $payment = $paymentModel->where('payment_id', $paymentID)->first();

            // Fetch customer details
            $db = \Config\Database::connect();
            $builder = $db->table('customer_tbl');
            $customer = $builder->where('customer_id', $customerId)->get()->getRow();

            $data = [
                'paymentID' => $paymentID,
                'orderID' => $orderID,
                'amount' => $amount,
                'userName' => $customer ? $customer->customer_name : 'Unknown',
                'date' => $this->getCurrentDate(),
                'time' => $this->getCurrentTime()
            ];

            return view('ecommerce/thank_you_1', $data);
        } else {
            return redirect()->to('/login')->with('error', 'Session not set');
        }
    }

    private function getCurrentDate()
    {
        return date("Y-m-d");
    }

    private function getCurrentTime()
    {
        date_default_timezone_set("Asia/Kolkata");
        return date("H:i:s");
    }
    public function clearCart()
    {

        $session = session();

        $session->remove('cart_item');

        return redirect()->to(base_url('fruitables'));
    }
    public function processPayment()
    {
        $session = session();
        
        $orderModel = new OrderModel();
        $paymentModel = new PaymentModel();

        $paymentID = $this->request->getPost('paymentID');
        $amount = $this->request->getPost('amount');
        $currency = $this->request->getPost('currency');
        $customer_id = $session->get('customer_id');

        if (!empty($paymentID) && !empty($amount) && !empty($currency) && !empty($customer_id)) {
            $lastOrder = $orderModel->orderBy('order_id', 'DESC')->first();
            $order_id = $lastOrder ? $lastOrder['order_id'] + 1 : 1001;

            $cartItems = $session->get('cart_item');
            $prod_names = array_column($cartItems, 'prod_name');
            $prod_quantities = array_column($cartItems, 'prod_quantity');
            $prod_prices = array_column($cartItems, 'prod_price');

            $prod_names_string = implode(', ', $prod_names);
            $prod_quantity_string = implode(', ', $prod_quantities);
            $prod_price_string = implode(', ', $prod_prices);

            $paymentData = [
                'order_id' => $order_id,
                'payer_id' => $customer_id,
                'payment_id' => $paymentID,
                'amount' => $amount,
                'currency' => $currency,
                'status' => 'Success'
            ];

            if ($paymentModel->save($paymentData)) {
                // Insert order data
                $orderData = [
                    'order_id' => $order_id,
                    'prod_name' => $prod_names_string,
                    'customer_id' => $customer_id,
                    'prod_quantity' => $prod_quantity_string,
                    'prod_price' => $prod_price_string,
                    'payment_mode' => 'PayPal'
                ];

                if ($orderModel->save($orderData)) {
                    // Clear cart session
                    $session->remove('cart_item');
                    return $this->response->setJSON(['success' => true, 'message' => $paymentID]);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Failed to record order.']);
                }
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to record payment.']);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid input data.']);
        }
    }
    public function success1()
    {
        $session = session();
        $paymentID = $this->request->getGet('paymentid');
        $customer_id = $session->get('customer_id');

        if (!$customer_id) {
            return redirect()->to(base_url('fruitables'))->with('error', 'Session not set');
        }
        // Load models
        $paymentModel = new PaymentModel();
        $customerModel = new CustomerModel();
        
        // Fetch payment data
        $paymentData = $paymentModel->where('payment_id', $paymentID)->first();
        if ($paymentData) {
            $order_id = $paymentData['order_id'];
            $amount = $paymentData['amount'];
            
            // Fetch customer data
            $customerData = $customerModel->where('customer_id', $customer_id)->first();
            $user_name = $customerData ? $customerData['customer_name'] : 'Unknown';
            
            $data = [
                'order_id' => $order_id,
                'amount' => $amount,
                'user_name' => $user_name,
                'date' => $this->getCurrentDate(),
                'time' => $this->getCurrentTime(),
                'paymentID' => $paymentID
            ];                                 
            
            return view('ecommerce/thank_you', $data);
        } else {
            return redirect()->to(base_url('fruitables'))->with('error', 'Invalid payment ID');
        }
    }
}

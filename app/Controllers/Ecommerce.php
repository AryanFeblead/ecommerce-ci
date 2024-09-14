<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Controller;
use CodeIgniter\Pager\Pager;

class Ecommerce extends BaseController
{
    public function index()
    {
        echo view('common/header');
        $productModel = new ProductModel();
        $data['fruitproducts'] = $productModel->where('prod_category', 'Fruit')->limit(4)->findAll();
        $data['vegeproducts'] = $productModel->where('prod_category', 'Vegetable')->limit(4)->findAll();
        $data['allproductstab'] = $productModel->limit(4)->findAll();
        $data['allproducts'] = $productModel->findAll();
        echo view('ecommerce/index', $data);
        echo view('common/footer');
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
    public function shop()
    {
        $productModel = new ProductModel();
        $pager = \Config\Services::pager();
        $currentPage = $this->request->getVar('page') ?: 1;

        $perPage = 6;
        $total = $productModel->countAllResults();
        $products = $productModel->paginate($perPage, 'aryan', $currentPage);
        
        $pager = $productModel->pager;

        $data = [
            'allproducts' => $products,
            'pager' => $pager
        ];

        echo view('common/header');
        echo view('ecommerce/shop', $data);
        echo view('common/footer');
    }
    public function cart()
    {
        echo view('common/header');
        
        $session = session();
        $data['cart_items'] = $session->get('cart_item');
        $totalAmount = 0;
        $cartItems = $session->get('cart_item');
        if ($cartItems && !empty($cartItems)) {
            foreach ($cartItems as $item) {
                $itemTotal = $item['prod_price'] * $item['prod_quantity'];
                $totalAmount += $itemTotal;
            }
        }
        $data['totalAmount'] = number_format($totalAmount, 2);

        echo view('ecommerce/cart', $data);
        echo view('common/footer');
    }
    public function checkout()
    {
        echo view('common/header');
        $productModel = new ProductModel();
        $data['allproducts'] = $productModel->findAll();
        echo view('ecommerce/checkout', $data);
        echo view('common/footer');
    }
    public function show($id)
    {
        echo view('common/header');
        $productModel = new ProductModel();
        $data['product'] = $productModel->where('prod_id', $id)->first();;

        if (!$data['product']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }
        echo view('ecommerce/shop-detail', $data);
        echo view('common/footer');
    }
    public function contact()
    {
        echo view('common/header');
        echo view('ecommerce/contact');
        echo view('common/footer');
    }
    public function addCart($id)
    {
        $productModel = new ProductModel();
        $session = session();
        $product  = $productModel->where('prod_id', $id)->first();;

        if (!$product ) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }
        $prod_id = $product['prod_id'];
        $prod_name = $product['prod_name'];
        $prod_price = $product['prod_price'];
        $prod_img = $product['prod_img'];

        if (!$session->has('cart_item')) {
            $session->set('cart_item', [
                $prod_id => [
                    'prod_id' => $prod_id,
                    'prod_name' => $prod_name,
                    'prod_img' => $prod_img,
                    'prod_price' => $prod_price,
                    'prod_quantity' => 1,
                    'prod_total' => $prod_price
                ]
            ]);
            return $this->response->setJSON(["status" => "success", "message" => "Item added to cart"]);
        } else {
            $cartItems = $session->get('cart_item');

            if (array_key_exists($prod_id, $cartItems)) {
                $cartItems[$prod_id]['prod_quantity'] += 1;
                $cartItems[$prod_id]['prod_total'] = $cartItems[$prod_id]['prod_quantity'] * $prod_price;
                $session->set('cart_item', $cartItems);
                return $this->response->setJSON(["status" => "success", "message" => "Item quantity updated"]);
            } else {
                $cartItems[$prod_id] = [
                    'prod_id' => $prod_id,
                    'prod_name' => $prod_name,
                    'prod_img' => $prod_img,
                    'prod_price' => $prod_price,
                    'prod_quantity' => 1,
                    'prod_total' => $prod_price
                ];
                $session->set('cart_item', $cartItems);
                return $this->response->setJSON(["status" => "success", "message" => "Item added to cart"]);
            }
        }
    }
    public function deleteCart($id)
    {
        $session = session();

        if (!$id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Product ID is required']);
        }

        $cartItems = $session->get('cart_item');

        if (isset($cartItems[$id])) {
            unset($cartItems[$id]);
            $session->set('cart_item', $cartItems);

            return $this->response->setJSON(['status' => 'success', 'message' => 'Item removed from cart']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Item not found in cart']);
        }
    }
    public function updateCart()
    {
        $session = session();
        
        if ($this->request->getMethod() === 'POST') {
            $itemId = intval($this->request->getPost('id'));
            $quantity = intval($this->request->getPost('quantity'));

            if ($itemId > 0 && $quantity > 0) {
                $cartItems = $session->get('cart_item');

                if (isset($cartItems[$itemId])) {
                    // Update quantity and total
                    $cartItems[$itemId]['prod_quantity'] = $quantity;
                    $cartItems[$itemId]['prod_total'] = $cartItems[$itemId]['prod_price'] * $quantity;

                    // Save updated cart back to session
                    $session->set('cart_item', $cartItems);

                    return $this->response->setJSON($cartItems);
                } else {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Item not found']);
                }
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid data']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request method']);
        }
    }
    public function view_data()
    {
        $search = $this->request->getPost('search');
        $productModel = new ProductModel();
        
        $builder = $productModel->table('prod_tbl');

        // Sanitize input and search query
        $search = $productModel->escapeLikeString($search);

        // Query the database
        $builder->like('prod_name', $search);
        $query = $builder->get();
        $results = $query->getResultArray();

        // Return JSON response
        return $this->response->setJSON($results);
    }
    public function fruit_data()
    {
        $productModel = new ProductModel();
        $result = $productModel->where('prod_category', 'Fruit')->findAll();
        return $this->response->setJSON($result);
    }
    public function vegetable_data()
    {
        $productModel = new ProductModel();
        $result = $productModel->where('prod_category', 'Vegetable')->findAll();
        return $this->response->setJSON($result);
    }
    public function searchbar_data()
    {
        $searchPrice = $this->request->getPost('searchprice');
        if (!is_numeric($searchPrice) || $searchPrice <= 0) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid price']);
        }
        $productModel = new ProductModel();
        $result = $productModel->where('prod_price <=', $searchPrice)->findAll();
        return $this->response->setJSON($result);
    }
    public function lowtohigh_data()
    {
        $searchPrice = $this->request->getPost('searchprice1');
        $search = $this->request->getPost('search');

        $db = \Config\Database::connect();
        $builder = $db->table('prod_tbl');

        $queryParts = [];
        
        if (!empty($search)) {
            $builder->like('prod_name', $search);
        }

        if (!empty($searchPrice)) {
            $builder->where('prod_price <=', $searchPrice);
        }

        $builder->orderBy('prod_price', 'ASC');

        $query = $builder->get();
        $results = $query->getResultArray();

        return $this->response->setJSON($results);
    }
    public function hightolow_data()
    {
        // Get POST data
        $searchPrice = $this->request->getPost('searchprice1');
        $search = $this->request->getPost('search');

        // Load the database
        $db = \Config\Database::connect();
        $builder = $db->table('prod_tbl');

        // Apply search filter
        if (!empty($search)) {
            $builder->like('prod_name', $search);
        }

        // Apply price filter
        if (!empty($searchPrice)) {
            $builder->where('prod_price <=', $searchPrice);
        }

        // Apply sorting
        $builder->orderBy('prod_price', 'DESC');

        // Execute query and fetch results
        $query = $builder->get();
        $results = $query->getResultArray();

        // Return JSON response
        return $this->response->setJSON($results);
    }
    public function atoz_data()
    {
        // Get POST data
        $searchPrice = $this->request->getPost('searchprice1');
        $search = $this->request->getPost('search');

        // Load the database
        $db = \Config\Database::connect();
        $builder = $db->table('prod_tbl');

        // Apply search filter
        if (!empty($search)) {
            $builder->like('prod_name', $search);
        }

        // Apply price filter
        if (!empty($searchPrice)) {
            $builder->where('prod_price <=', $searchPrice);
        }

        // Apply alphabetical sorting
        $builder->orderBy('prod_name', 'ASC');

        $query = $builder->get();
        $results = $query->getResultArray();

        return $this->response->setJSON($results);
    }
    public function ztoa_data()
    {

        $searchPrice = $this->request->getPost('searchprice1');
        $search = $this->request->getPost('search');

        $db = \Config\Database::connect();
        $builder = $db->table('prod_tbl');

        if (!empty($search)) {
            $builder->like('prod_name', $search);
        }

        if (!empty($searchPrice)) {
            $builder->where('prod_price <=', $searchPrice);
        }

        $builder->orderBy('prod_name', 'DESC');

        $query = $builder->get();
        $results = $query->getResultArray();

        return $this->response->setJSON($results);
    }
}

<?php 

namespace App\Models;

use CodeIgniter\Model;

class BillModel extends Model
{
    protected $table = 'bill_tbl';
    protected $primaryKey = 'bill_id'; 
    protected $allowedFields = [ 'fname', 'lname', 'address','city','country','postcode','mobile','email','order_id','subtotal','customer_id'];

    protected $returnType = 'array';

    public function insertBill($formData, $orderId, $totalAmount, $customerId)
    {
        $data = [
            'fname' => $formData['fname'],
            'lname' => $formData['lname'],
            'address' => $formData['address'],
            'city' => $formData['city'],
            'country' => $formData['country'],
            'postcode' => $formData['postcode'],
            'mobile' => $formData['mobile'],
            'email' => $formData['email'],
            'order_id' => $orderId,
            'subtotal' => $totalAmount,
            'customer_id' => $customerId
        ];

        $this->save($data);
    }
}
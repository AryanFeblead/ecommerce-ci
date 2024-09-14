<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'order_tbl';
    protected $primaryKey = 'order_id';
    protected $allowedFields = ['prod_name', 'prod_id', 'prod_quantity', 'prod_price', 'payment_mode'];

    protected $returnType = 'array';

    public function getNextOrderId()
    {
        $builder = $this->builder();
        $builder->selectMax('order_id');
        $result = $builder->get()->getRowArray();
        return ($result['order_id'] ?? 1000) + 1;
    }
    public function insertOrder($orderId, $cartItem, $customerId)
    {
        $prodNames = implode(', ', array_column($cartItem, 'prod_name'));
        $prodQuantities = implode(', ', array_column($cartItem, 'prod_quantity'));
        $prodPrices = implode(', ', array_column($cartItem, 'prod_price'));

        $data = [
            'order_id' => $orderId,
            'prod_name' => $prodNames,
            'customer_id' => $customerId,
            'prod_quantity' => $prodQuantities,
            'prod_price' => $prodPrices,
            'payment_mode' => 'COD'
        ];

        $this->insert($data);
    }
}

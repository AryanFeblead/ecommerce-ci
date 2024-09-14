<?php 

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['order_id', 'payer_id', 'payment_id', 'amount','currency','status'];

    protected $returnType = 'array';
}
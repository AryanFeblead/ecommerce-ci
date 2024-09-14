<?php 

namespace App\Models;

use CodeIgniter\Model;

class CardModel extends Model
{
    protected $table = 'card_payment';
    protected $primaryKey = 'id'; 
    protected $allowedFields = [ 'order_id', 'payer_id', 'payment_id','amount','currency','status'];

    protected $returnType = 'array';
}
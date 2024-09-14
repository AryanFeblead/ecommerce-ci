<?php namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customer_tbl';
    protected $primaryKey = 'customer_id'; // or whatever the primary key is
    protected $allowedFields = ['customer_id', 'customer_name'];
}

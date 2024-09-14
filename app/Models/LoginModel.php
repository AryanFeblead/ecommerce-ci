<?php 

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'customer_tbl';
    protected $allowedFields = ['customer_name','customer_email','customer_password'];
    protected $userTimestamps = true;
}
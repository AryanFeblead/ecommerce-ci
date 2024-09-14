<?php 

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'prod_tbl';
    protected $primaryKey = 'prod_id'; 
    protected $allowedFields = ['prod_img', 'prod_name', 'prod_description', 'prod_price','prod_category'];

    protected $returnType = 'array';
}
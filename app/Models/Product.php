<?php

namespace App\Models;

use CodeIgniter\Model;

class Product extends Model
{
  protected $table = 'products';
  protected $primaryKey = 'product_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $allowedFields = ['product_name', 'product_description', 'product_price', 'product_stock', 'product_status', 'product_annotation', 'category_id', 'supplier_id'];
}

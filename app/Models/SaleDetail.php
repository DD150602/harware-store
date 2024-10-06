<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleDetail extends Model
{
  protected $table = 'sale_detail';
  protected $primaryKey = 'sale_detail_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $allowedFields = ['sale_detail_id', 'sale_quantity', 'sale_unit_price', 'sale_id', 'product_id',];
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseDetail extends Model
{
  protected $table = 'purchase_detail';
  protected $primaryKey = 'purchase_detail_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $allowedFields = ['purchase_detail_id', 'purchase_quantity', 'purchase_unit_price', 'purchase_id', 'product_id'];
}

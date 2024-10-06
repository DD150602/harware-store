<?php

namespace App\Models;

use CodeIgniter\Model;

class Purchase extends Model
{
  protected $table = 'purchases';
  protected $primaryKey = 'purchase_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $allowedFields = ['purchase_total', 'purchase_date', 'supplier_id', 'user_id'];
}

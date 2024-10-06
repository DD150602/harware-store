<?php

namespace App\Models;

use CodeIgniter\Model;

class Sale extends Model
{
  protected $table = 'sales';
  protected $primaryKey = 'sale_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $allowedFields = ['sale_total', 'sale_date', 'client_id', 'user_id'];
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class Supplier extends Model
{
  protected $table = 'suppliers';
  protected $primaryKey = 'supplier_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $allowedFields = ['supplier_id', 'supplier_name', 'supplier_contact', 'supplier_phone', 'supplier_address'];
}

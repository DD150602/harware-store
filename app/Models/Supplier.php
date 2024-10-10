<?php

namespace App\Models;

use CodeIgniter\Model;

class Supplier extends Model
{
  protected $table = 'suppliers';
  protected $primaryKey = 'supplier_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $useSoftDeletes = true;
  protected $allowedFields = ['supplier_id', 'supplier_name', 'supplier_contact', 'supplier_phone', 'supplier_address'];
  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'supplier_created_at';
  protected $updatedField = 'supplier_updated_at';
  protected $deletedField = 'supplier_deleted_at';
}

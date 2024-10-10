<?php

namespace App\Models;

use CodeIgniter\Model;

class Purchase extends Model
{
  protected $table = 'purchases';
  protected $primaryKey = 'purchase_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $useSoftDeletes = true;
  protected $allowedFields = ['purchase_total', 'purchase_date', 'supplier_id', 'user_id'];
  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'purchase_created_at';
  protected $updatedField = 'purchase_updated_at';
  protected $deletedField = 'purchase_deleted_at';
}

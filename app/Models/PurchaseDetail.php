<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseDetail extends Model
{
  protected $table = 'purchase_detail';
  protected $primaryKey = 'purchase_detail_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $useSoftDeletes = true;
  protected $allowedFields = ['purchase_detail_id', 'purchase_quantity', 'purchase_unit_price', 'purchase_id', 'product_id'];
  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'purchase_detail_created_at';
  protected $updatedField = 'purchase_detail_updated_at';
  protected $deletedField = 'purchase_detail_deleted_at';
}

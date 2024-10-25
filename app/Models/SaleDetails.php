<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleDetails extends Model
{
  protected $table = 'sale_details';
  protected $primaryKey = 'sale_detail_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $useSoftDeletes = true;
  protected $allowedFields = ['sale_detail_id', 'sale_quantity', 'sale_unit_price', 'sale_id', 'product_id',];
  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'sale_detail_created_at';
  protected $updatedField = 'sale_detail_updated_at';
  protected $deletedField = 'sale_detail_deleted_at';
}

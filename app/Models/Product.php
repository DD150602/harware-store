<?php

namespace App\Models;

use CodeIgniter\Model;

class Product extends Model
{
  protected $table = 'products';
  protected $primaryKey = 'product_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $useSoftDeletes = true;
  protected $allowedFields = ['product_name', 'product_description', 'product_price', 'product_stock', 'product_status', 'product_annotation', 'category_id', 'supplier_id'];
  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'product_created_at';
  protected $updatedField = 'product_updated_at';
  protected $deletedField = 'product_deleted_at';
}

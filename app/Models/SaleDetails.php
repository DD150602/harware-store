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

  public function getSaleDetailsBySaleId($saleId)
  {
    return $this->select('sale_detail_id, sale_quantity, sale_unit_price, sale_id, products.product_id, products.product_name')
      ->join('products', 'sale_details.product_id = products.product_id')
      ->where('sale_id', $saleId)->findAll();
  }
}

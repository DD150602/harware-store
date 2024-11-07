<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseDetails extends Model
{
  protected $table = 'purchase_details';
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

  public function getPurchaseDetails($id)
  {
    return $this->select('purchase_details.purchase_detail_id, purchase_details.purchase_quantity, purchase_details.purchase_unit_price, purchase_details.purchase_id, purchase_details.product_id, products.product_name')
      ->join('products', 'purchase_details.product_id = products.product_id')
      ->where('purchase_id', $id)
      ->findAll();
  }
}

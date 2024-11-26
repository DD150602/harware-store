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

  /**
   * Get details of a specific purchase by its ID.
   * 
   * This method retrieves all the details of a specific purchase, including 
   * the purchase quantity, unit price, and product information. It joins the 
   * `purchase_details` table with the `products` table to return product names 
   * along with the associated purchase data. 
   * 
   * @param int $id The ID of the purchase to retrieve the details for.
   * 
   * @return array Returns an array of purchase details, including product information, 
   *               or an empty array if no details are found for the given purchase ID.
   */
  public function getPurchaseDetails(int $id)
  {
    return $this->select('purchase_details.purchase_detail_id, purchase_details.purchase_quantity, purchase_details.purchase_unit_price, purchase_details.purchase_id, purchase_details.product_id, products.product_name')
      ->join('products', 'purchase_details.product_id = products.product_id')
      ->where('purchase_id', $id)
      ->findAll();
  }
}

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

  /**
   * Retrieve sale details by sale ID.
   * 
   * This method retrieves the details of a specific sale by its `sale_id`, including
   * information about the products involved in the sale. The details include the sale
   * quantity, sale unit price, and product name, as well as the product ID.
   * 
   * @param int $saleId The ID of the sale whose details are to be retrieved.
   * 
   * @return array Returns an array of sale details, each containing `sale_detail_id`, 
   *               `sale_quantity`, `sale_unit_price`, `sale_id`, `product_id`, and 
   *               `product_name`.
   */
  public function getSaleDetailsBySaleId(int $saleId)
  {
    return $this->select('sale_detail_id, sale_quantity, sale_unit_price, sale_id, products.product_id, products.product_name')
      ->join('products', 'sale_details.product_id = products.product_id')
      ->where('sale_id', $saleId)->findAll();
  }
}

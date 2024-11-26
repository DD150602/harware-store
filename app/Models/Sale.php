<?php

namespace App\Models;

use CodeIgniter\Model;

class Sale extends Model
{
  protected $table = 'sales';
  protected $primaryKey = 'sale_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $useSoftDeletes = true;
  protected $allowedFields = ['sale_total', 'sale_date', 'client_id', 'user_id'];
  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'sale_date';
  protected $updatedField = 'sale_updated_at';
  protected $deletedField = 'sale_deleted_at';

  /**
   * Retrieve all sales with details.
   * 
   * This method retrieves all sales from the `sales` table, joining related information
   * from the `clients` and `users` tables to include client names and user names associated
   * with each sale.
   * 
   * @return array Returns an array of sales, each containing `sale_id`, `sale_total`, 
   *               `sale_date`, `client_name`, and `user_name`.
   */
  public function getAllSales()
  {
    return $this->select('sale_id, sale_total, sale_date, clients.client_name, users.user_name')
      ->join('clients', 'sales.client_id = clients.client_id')
      ->join('users', 'sales.user_id = users.user_id')
      ->findAll();
  }

  /**
   * Retrieve a sale by its ID with detailed information.
   * 
   * This method retrieves the details of a specific sale by its `sale_id`, joining 
   * related data from the `clients` and `users` tables to include the client name 
   * and user name associated with the sale.
   * 
   * @param int $saleId The ID of the sale to retrieve.
   * 
   * @return array|null Returns the sale details, including `sale_id`, `sale_total`, 
   *                    `sale_date`, `client_name`, and `user_name`, or null if no sale 
   *                    is found with the provided ID.
   */
  public function getSaleById($saleId)
  {
    return $this->select('sales.sale_id, sale_total, sale_date, clients.client_name, users.user_name')
      ->join('clients', 'sales.client_id = clients.client_id')
      ->join('users', 'sales.user_id = users.user_id')
      ->where('sales.sale_id', $saleId)
      ->first();
  }
}

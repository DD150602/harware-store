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
  protected $createdField = 'purchase_date';
  protected $updatedField = 'purchase_updated_at';
  protected $deletedField = 'purchase_deleted_at';

  /**
   * Get all purchases with supplier and user details.
   * 
   * This method retrieves all purchase records from the database, including 
   * the purchase ID, total, date, associated supplier name, and user name 
   * (who recorded the purchase). It returns all records from the `purchases` table
   * with relevant information joined from the `suppliers` and `users` tables.
   * 
   * @return array Returns an array of purchase records, each containing purchase details and related supplier and user info.
   */
  public function getAllPurchases()
  {
    return $this->select('purchases.purchase_id, purchases.purchase_total, purchases.purchase_date, suppliers.supplier_name, users.user_name')
      ->join('suppliers', 'purchases.supplier_id = suppliers.supplier_id')
      ->join('users', 'purchases.user_id = users.user_id')
      ->findAll();
  }

  /**
   * Get a specific purchase by ID with supplier and user details.
   * 
   * This method retrieves the details of a specific purchase by its ID, including 
   * the purchase ID, total, date, associated supplier name, and the user name 
   * (who recorded the purchase). It returns a single record from the `purchases` table
   * along with the related supplier and user information.
   * 
   * @param int $id The ID of the purchase to retrieve.
   * 
   * @return array|null Returns an array containing the details of the purchase, or null if the purchase ID is not found.
   */
  public function getPurchase(int $id)
  {
    return $this->select('purchases.purchase_id, purchases.purchase_total, purchases.purchase_date, suppliers.supplier_name, users.user_name')
      ->join('suppliers', 'purchases.supplier_id = suppliers.supplier_id')
      ->join('users', 'purchases.user_id = users.user_id')
      ->where('purchases.purchase_id', $id)
      ->first();
  }
}

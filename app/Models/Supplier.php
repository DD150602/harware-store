<?php

namespace App\Models;

use CodeIgniter\Model;

class Supplier extends Model
{
  protected $table = 'suppliers';
  protected $primaryKey = 'supplier_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $useSoftDeletes = true;
  protected $allowedFields = ['supplier_id', 'supplier_name', 'supplier_contact', 'supplier_phone', 'supplier_address', 'supplier_created_by', 'supplier_deleted_at'];
  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'supplier_created_at';
  protected $updatedField = 'supplier_updated_at';
  protected $deletedField = 'supplier_deleted_at';

  /**
   * Retrieve all suppliers.
   * 
   * This method retrieves all the suppliers in the database, including their 
   * name, contact, phone number, address, and ID.
   * 
   * @return array Returns an array of all suppliers with the specified fields.
   */
  public function getAllSuppliers()
  {
    return $this->select('supplier_name, supplier_contact, supplier_phone, supplier_address, supplier_id')
      ->findAll();
  }

  /**
   * Retrieve a supplier by ID.
   * 
   * This method retrieves the details of a specific supplier identified by 
   * its `supplier_id`, including the supplier's name, contact, phone number, 
   * address, and ID.
   * 
   * @param int $id The ID of the supplier to retrieve.
   * 
   * @return array|null Returns the supplier details or null if no supplier is found.
   */
  public function getSupplier(int $id)
  {
    return $this->select('supplier_name, supplier_contact, supplier_phone, supplier_address, supplier_id')
      ->where('supplier_id', $id)
      ->first();
  }

  /**
   * Retrieve a supplier for a purchase by name or phone.
   * 
   * This method retrieves a supplier based on either the supplier's name or 
   * phone number. It helps in finding an existing supplier for a purchase.
   * 
   * @param array $data An array containing the supplier's `supplier_name` 
   *                    or `supplier_phone` to search by.
   * 
   * @return array|null Returns the supplier details or null if no supplier is found.
   */
  public function getSupplierToPurchase(array $data)
  {
    return $this->select('supplier_name, supplier_phone, supplier_address, supplier_id')
      ->where('supplier_name', $data['supplier_name'])
      ->orWhere('supplier_phone', $data['supplier_phone'])
      ->first();
  }

  /**
   * Create a new supplier.
   * 
   * This method creates a new supplier in the database. It checks if a supplier 
   * with the same name, phone, contact, or address already exists. If so, it 
   * updates the existing supplier by setting the `supplier_deleted_at` field 
   * to `null`. If the supplier is new, it is inserted into the database.
   * 
   * @param array $data An array containing the supplier's details to be inserted.
   * 
   * @return int Returns a status code: 
   *             1 - success, 
   *             2 - failure, 
   *             4 - supplier already exists and was updated.
   */
  public function createSupplier(array $data)
  {
    $dataExists = $this->where('supplier_phone', $data['supplier_phone'])
      ->orWhere('supplier_contact', $data['supplier_contact'])
      ->orWhere('supplier_name', $data['supplier_name'])
      ->orWhere('supplier_address', $data['supplier_address'])
      ->first();
    if ($dataExists) {
      $this->update($dataExists->supplier_id, ['supplier_deleted_at' => null]);
      return 4;
    } else {
      $this->insert($data);
      return 1;
    }
    return 2;
  }

  /**
   * Update an existing supplier.
   * 
   * This method updates the details of an existing supplier identified by 
   * `supplier_id`.
   * 
   * @param int $id The ID of the supplier to update.
   * @param array $data An array containing the updated supplier details.
   * 
   * @return int Returns a status code: 1 for success.
   */
  public function updateSupplier(int $id, array $data): int
  {
    $this->update($id, $data);
    return 1;
  }

  /**
   * Delete a supplier by ID.
   * 
   * This method deletes a supplier by marking it as deleted or removing it 
   * entirely based on your business logic.
   * 
   * @param int $id The ID of the supplier to delete.
   * 
   * @return int Returns a status code: 
   *             3 - success, 
   *             2 - failure.
   */
  public function deleteSupplier($id)
  {
    $result = $this->delete($id);
    if ($result) {
      return 3;
    } else {
      return 2;
    }
  }
}

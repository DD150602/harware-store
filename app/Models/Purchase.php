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

  public function getAllPurchases()
  {
    return $this->select('purchases.purchase_id, purchases.purchase_total, purchases.purchase_date, suppliers.supplier_name, users.user_name')
      ->join('suppliers', 'purchases.supplier_id = suppliers.supplier_id')
      ->join('users', 'purchases.user_id = users.user_id')
      ->findAll();
  }

  public function getPurchase($id){
    return $this->select('purchases.purchase_id, purchases.purchase_total, purchases.purchase_date, suppliers.supplier_name, users.user_name')
      ->join('suppliers', 'purchases.supplier_id = suppliers.supplier_id')
      ->join('users', 'purchases.user_id = users.user_id')
      ->where('purchases.purchase_id', $id)
      ->first();
  }
}

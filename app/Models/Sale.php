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

  public function getAllSales()
  {
    return $this->select('sale_id, sale_total, sale_date, clients.client_name, users.user_name')
      ->join('clients', 'sales.client_id = clients.client_id')
      ->join('users', 'sales.user_id = users.user_id')
      ->findAll();
  }

  public function getSaleById($saleId)
  {
    return $this->select('sales.sale_id, sale_total, sale_date, clients.client_name, users.user_name')
      ->join('clients', 'sales.client_id = clients.client_id')
      ->join('users', 'sales.user_id = users.user_id')
      ->where('sales.sale_id', $saleId)
      ->first();
  }
}

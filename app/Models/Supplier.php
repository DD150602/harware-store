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

  public function getAllSuppliers()
  {
    return $this->select('supplier_name, supplier_contact, supplier_phone, supplier_address, supplier_id')
      ->findAll();
  }

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
}

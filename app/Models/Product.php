<?php

namespace App\Models;

use CodeIgniter\Model;

class Product extends Model
{
  protected $table = 'products';
  protected $primaryKey = 'product_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $useSoftDeletes = true;
  protected $allowedFields = ['product_id', 'product_name', 'product_description', 'product_price', 'product_stock', 'product_status', 'product_annotation', 'category_id', 'supplier_id', 'product_created_by'];
  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'product_created_at';
  protected $updatedField = 'product_updated_at';
  protected $deletedField = 'product_deleted_at';

  public function getAllProducts()
  {
    return $this->select('product_name, product_price, product_stock, product_id')
      ->where('product_status', true)
      ->findAll();
  }

  public function getProduct($id)
  {
    return $this->select('product_name, product_description, product_price, product_stock, product_id, supplier_name, category_name, products.category_id, products.supplier_id')
      ->join('suppliers', 'products.supplier_id = suppliers.supplier_id')
      ->join('categories', 'products.category_id = categories.category_id')
      ->where('product_id', $id)
      ->where('product_status', true)
      ->first();
  }

  public function updateProduct(array $data): int
  {
    $productId = $data['product_id'];
    unset($data['product_id']);
    $update = $this->update($productId, $data);
    if ($update) {
      return 1;
    } else {
      return 2;
    }
  }

  public function deleteProduct($data)
  {
    $productId = $data['product_id'];
    unset($data['product_id']);
    $this->update($productId, $data);
    $result = $this->delete($productId);
    if ($result) {
      return 1;
    } else {
      return 2;
    }
  }
}

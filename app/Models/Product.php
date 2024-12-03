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

  /**
   * Retrieve all active products from the database, optionally filtered by a search term.
   * 
   * This method retrieves a list of all active products from the database, joining with 
   * the `suppliers` and `categories` tables to include supplier and category information. 
   * If a search term (`$filterBy`) is provided, it will filter products by name, description, 
   * or category name using a `LIKE` search.
   * 
   * @param string|null $filterBy The search term to filter products by (optional).
   *                              If provided, it filters product name, description, or category.
   * 
   * @return array An array of products matching the filter (if any), including their 
   *               name, price, stock, ID, and associated category name.
   */
  public function getAllProducts($filterBy = null)
  {
    $result = $this->select('product_name, product_price, product_stock, product_id, category_name');
    if (gettype($filterBy) == 'string') {
      $filters = ['product_name' => $filterBy, 'product_description' => $filterBy, 'category_name' => $filterBy];
      $result->orLike($filters);
    }
    return $result->join('suppliers', 'products.supplier_id = suppliers.supplier_id')
      ->join('categories', 'products.category_id = categories.category_id')
      ->where('product_status', true)
      ->findAll();
  }

  /**
   * Retrieve a specific active product by its ID, including related supplier and category information.
   * 
   * This method fetches the details of a specific product based on its ID, including the product's
   * name, description, price, stock, associated supplier name, and category name. It ensures the product
   * is active by checking the `product_status` field. The method also joins the `suppliers` and `categories` 
   * tables to retrieve relevant supplier and category information.
   * 
   * @param int $id The ID of the product to retrieve.
   * 
   * @return object|null An object containing the product details (name, description, price, stock, 
   *                    supplier name, category name) or null if no product is found with the provided ID.
   */
  public function getProduct(int $id)
  {
    return $this->select('product_name, product_description, product_price, product_stock, product_id, supplier_name, category_name, products.category_id, products.supplier_id')
      ->join('suppliers', 'products.supplier_id = suppliers.supplier_id')
      ->join('categories', 'products.category_id = categories.category_id')
      ->where('product_id', $id)
      ->where('product_status', true)
      ->first();
  }

  /**
   * Retrieve a list of products with low stock (10 or fewer units), including related supplier, category, and creator information.
   * 
   * This method retrieves all active products with 10 or fewer units in stock. It returns relevant details for each
   * product, such as the product's name, description, price, stock quantity, supplier name, category name, and the name 
   * of the user who created the product. The method joins the `suppliers`, `categories`, and `users` tables to fetch 
   * necessary related data.
   * 
   * @return array An array of associative arrays, each containing product details (name, description, price, stock, 
   *               supplier name, category name, and user who created the product).
   */
  public function lowStockProducts()
  {
    return $this->select('product_name, product_description, product_price, product_stock, supplier_name, category_name, CONCAT_WS(" ", user_name, user_lastname) as user')
      ->join('suppliers', 'products.supplier_id = suppliers.supplier_id')
      ->join('categories', 'products.category_id = categories.category_id')
      ->join('users', 'products.product_created_by = users.user_id')
      ->where('product_status', true)
      ->where('product_stock <= 10')
      ->findAll();
  }

  /**
   * Update product details in the database.
   * 
   * This method updates the details of an existing product in the database based on the provided data.
   * It accepts an associative array containing product information, excluding the product ID, which is 
   * automatically extracted and used to identify the product to be updated.
   * 
   * @param array $data An associative array containing the updated product details, including the product ID.
   * 
   * @return int Returns 1 if the update is successful, and 2 if the update fails.
   */
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

  /**
   * Delete a product from the database.
   * 
   * This method first updates the product's status (or any other data passed in `$data`), 
   * and then deletes the product from the database. The `product_id` from the `$data` array 
   * is used to identify the product to be deleted. After deletion, it returns a success or failure status.
   * 
   * @param array $data An associative array containing the product's `product_id` and any other data to be updated before deletion.
   * 
   * @return int Returns 1 if the deletion is successful, and 2 if the deletion fails.
   */
  public function deleteProduct(array $data): int
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

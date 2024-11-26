<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
  protected $table = 'categories';
  protected $primaryKey = 'category_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $useSoftDeletes = true;
  protected $allowedFields = ['category_id', 'category_name'];
  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'category_created_at';
  protected $updatedField = 'category_updated_at';
  protected $deletedField = 'category_deleted_at';

  /**
   * Retrieves all categories from the database.
   *
   * @return array An array of objects where each object
   *               contains the properties of a category.
   */
  public function getCategories()
  {
    return $this->findAll();
  }
}

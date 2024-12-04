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
  protected $allowedFields = ['category_id', 'category_name', 'category_created_by'];
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

  /**
   * Creates a new category.
   *
   * This method takes an array of category data to create a new category in the
   * database. If the category is successfully created, it returns a status code of 1.
   * If the category fails to be inserted, it returns a status code of 2.
   *
   * @param array $data An array containing category data, such as the name and
   *                    creator's user ID.
   *
   * @return int Returns a status code for the category creation attempt.
   */
  public function newCategory(array $data): int
  {
    if ($this->insert($data)) {
      return 1;
    }
    return 2;
  }
}

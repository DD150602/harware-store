<?php

namespace App\Models;

use CodeIgniter\Model;

class RolesModel extends Model
{
  protected $table = 'roles';
  protected $primaryKey = 'role_id';
  protected $returnType = 'object';
  protected $useSoftDeletes = true;
  protected $allowedFields = ['role_id', 'role_name'];
  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'role_created_at';
  protected $updatedField = 'role_updated_at';
  protected $deletedField = 'role_deleted_at';

  /**
   * Get all roles except for the 'Superadmin' role.
   * 
   * This method retrieves all roles from the roles table, excluding the 'Superadmin' 
   * role, and returns an array containing role IDs and role names.
   * 
   * @return array Returns an array of roles, each containing a `role_id` and `role_name`. 
   *               The 'Superadmin' role is excluded from the results.
   */
  public function getAllRoles()
  {
    return $this->select('role_id, role_name')
      ->where('role_name  !=', 'Superadmin')
      ->findAll();
  }
}

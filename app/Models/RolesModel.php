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
}
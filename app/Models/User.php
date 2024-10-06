<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
  protected $table = 'users';
  protected $primaryKey = 'user_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $allowedFields = ['user_id', 'user_name', 'user_lastname', 'user_email', 'user_username', 'user_password', 'role_id', 'user_status', 'user_annotation'];
}

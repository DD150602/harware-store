<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
  protected $table = 'users';
  protected $primaryKey = 'user_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $useSoftDeletes = true;
  protected $allowedFields = ['user_id', 'user_name', 'user_lastname', 'user_email', 'user_username', 'user_password', 'role_id', 'user_status', 'user_annotation'];
  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'user_created_at';
  protected $updatedField = 'user_updated_at';
  protected $deletedField = 'user_deleted_at';

  public function getAllUsers()
  {
    return  $this->select('user_id, user_name, role_name, user_created_at')
      ->join('roles', 'users.role_id = roles.role_id')
      ->where('user_status', true)
      ->findAll();
  }

  {
    if ($this->validateUsername($data['user_username'])) {
      return [
        'create' => false,
        'message' => 'El nombre de usuario ya se encuentra registrado'
      ];
    }

    if ($this->validateEmail($data['user_email'])) {
      return [
        'create' => false,
        'message' => 'El email ya se encuentra registrado'
      ];
    }

    $hashedPassword = password_hash($data['user_password'], PASSWORD_BCRYPT, ['cost' => 10]);
    $data['user_password'] = $hashedPassword;
    $this->insert($data);
    return [
      'create' => true,
      'message' => 'Usuario creado correctamente'
    ];
  }

  public function login($data)
  {
    $user = $this->select('user_username, role_name, user_password, user_id')
      ->join('roles', 'users.role_id = roles.role_id')
      ->where('user_email', $data['user_email'])
      ->where('user_status', true)
      ->first();

    if (!$this->validateEmail($data['user_email'])) {
      return [
        'login' => false,
        'message' => 1
      ];
    }

    if (password_verify($data['user_password'], $user->user_password)) {
      return [
        'user_id' => $user->user_id,
        'user_username' => $user->user_username,
        'user_role' => $user->role_name,
        'login' => true
      ];
    } else {
      return [
        'login' => false,
        'message' => 2
      ];
    }
  }

  private function validateEmail($email)
  {
    $user = $this->where('user_email', $email)
      ->where('user_status', true)
      ->findAll();

    if ($user) {
      return true;
    } else {
      return false;
    }
  }

  private function validateUsername($username)
  {
    $user = $this->where('user_username', $username)
      ->where('user_status', true)
      ->findAll();

    if ($user) {
      return true;
    } else {
      return false;
    }
  }
}

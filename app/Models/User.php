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

  /**
   * Retrieve all active users.
   * 
   * This method retrieves all users who are active, including their user ID, 
   * name, role, and account creation date. It joins with the roles table to 
   * fetch role information.
   * 
   * @return array Returns an array of active users with the specified fields.
   */
  public function getAllUsers()
  {
    return  $this->select('user_id, user_name, role_name, user_created_at')
      ->join('roles', 'users.role_id = roles.role_id')
      ->where('user_status', true)
      ->findAll();
  }

  /**
   * Retrieve a specific user by ID.
   * 
   * This method retrieves the details of a specific user identified by 
   * `user_id`, including the user's name, lastname, email, username, role, 
   * and account status.
   * 
   * @param int $id The ID of the user to retrieve.
   * 
   * @return array|null Returns the user details or null if no user is found.
   */
  public function getUser(int $id)
  {
    return $this->select('user_id, user_name, user_lastname, user_email, user_username, users.role_id, role_name, user_status')
      ->join('roles', 'users.role_id = roles.role_id')
      ->where('user_id', $id)
      ->where('user_status', true)
      ->first();
  }

  /**
   * Create a new user.
   * 
   * This method creates a new user by validating the username and email. If 
   * the username or email already exists, it returns a specific error code. 
   * If validation passes, it hashes the user's password and inserts the user 
   * into the database.
   * 
   * @param array $data An array containing the user's details, including 
   *                    username, email, password, etc.
   * 
   * @return int Returns a status code:
   *             1 - success,
   *             3 - username already taken,
   *             4 - email already in use.
   */
  public function createUser(array $data): int
  {
    if ($this->validateUsername($data['user_username'])) {
      return 3;
    }

    if ($this->validateEmail($data['user_email'])) {
      return 4;
    }

    $hashedPassword = password_hash($data['user_password'], PASSWORD_BCRYPT, ['cost' => 10]);
    $data['user_password'] = $hashedPassword;
    $this->insert($data);
    return 1;
  }

  /**
   * Update an existing user's information.
   * 
   * This method updates a user's details based on the provided user ID and 
   * new data.
   * 
   * @param int $id The ID of the user to update.
   * @param array $data An array containing the updated user details.
   * 
   * @return int Returns a status code (1 for success).
   */
  public function updateUser(int $id, array $data): int
  {
    $this->update($id, $data);
    return 1;
  }

  /**
   * Delete a user by ID.
   * 
   * This method deletes a user by marking it as deleted or removing it 
   * based on the operation result. The `user_id` is removed from the 
   * request data and the user is updated before deletion.
   * 
   * @param array $data An array containing the user's ID and other data.
   * 
   * @return int Returns a status code:
   *             5 - success,
   *             2 - failure.
   */
  public function deleteUser(array $data): int
  {
    $userId = $data['user_id'];
    unset($data['user_id']);
    $this->update($userId, $data);
    $result = $this->delete($userId);
    if ($result) {
      return 5;
    } else {
      return 2;
    }
  }

  /**
   * Log in a user.
   * 
   * This method attempts to log in a user by checking if the provided email 
   * exists and if the password is correct. It returns user details and a login 
   * status if successful, or an error message if the login fails.
   * 
   * @param array $data An array containing the user's email and password.
   * 
   * @return array Returns an array with login status and user details, or error message.
   */
  public function login(array $data): array
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

  /**
   * Validate if the email is already in use.
   * 
   * This method checks if the given email is already registered in the system 
   * and active.
   * 
   * @param string $email The email to validate.
   * 
   * @return bool Returns true if the email is taken, false otherwise.
   */
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

  /**
   * Validate if the username is already in use.
   * 
   * This method checks if the given username is already registered and active.
   * 
   * @param string $username The username to validate.
   * 
   * @return bool Returns true if the username is taken, false otherwise.
   */
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

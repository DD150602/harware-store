<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\RolesModel;

class Users extends BaseController
{
  protected $users;
  protected $roles;
  protected $data = [];
  public function __construct()
  {
    $this->users = new User();
    $this->roles = new RolesModel();
    $this->data['users'] = $this->users->getAllUsers();
    $this->data['roles'] = $this->roles->getAllRoles();
  }

  public function index()
  {
    return view('Users/Users', $this->data);
  }
}

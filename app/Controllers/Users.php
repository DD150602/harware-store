<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{

  public function index()
  {
    return view('Users/Users');
  }
}

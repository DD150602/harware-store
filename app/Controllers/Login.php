<?php

namespace App\Controllers;

use App\Models\User;

class Login extends BaseController
{
  public function index(): string
  {
    return view('Login');
  }

}

<?php

namespace App\Controllers;

use App\Models\User;

class Login extends BaseController
{
  protected $user;

  public function __construct()
  {
    $this->user = new User();
  }
  public function index(): string
  {
    return view('Login');
  }

  public function login()
  {
    $rules = [
      'user_email' => [
        'rules' => 'required|valid_email',
        'errors' => [
          'required' => 'The email field is required',
          'valid_email' => 'The email field must contain a valid email address'
        ]
      ],
      'user_password' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The password field is required'
        ]
      ]
    ];

    if (!$this->validate($rules)) {
      return redirect()->back()->withInput();
    } else {
      $data = [
        'user_email' => $this->request->getPost('user_email'),
        'user_password' => $this->request->getPost('user_password')
      ];

      $login_info = $this->user->login($data);

      if ($login_info['login'] && $login_info['user_role'] == 'Superadmin') {
        return redirect()->to('/admin');
      } else {
        return redirect()->to('/')->with('message', $login_info['message']);
      }
    }
  }

  public function logout()
  {
    $this->session->destroy();
    return redirect()->to('/');
  }
}

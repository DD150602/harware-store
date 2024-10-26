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

  public function user($id)
  {
    $this->data['user'] = $this->users->getUser($id);
    return view('Users/UserDetails', $this->data);
  }

  public function create()
  {
    $rules = [
      'user_name' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The user name field is required'
        ]
      ],
      'user_lastname' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The last name field is required'
        ]
      ],
      'user_email' => [
        'rules' => 'required|valid_email|is_unique[users.user_email]',
        'errors' => [
          'required' => 'The email field is required',
          'valid_email' => 'The email field must contain a valid email address',
          'is_unique' => 'The email field must contain a unique email address'
        ]
      ],
      'user_password' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The password field is required'
        ]
      ],
      'user_username' => [
        'rules' => 'required|is_unique[users.user_username]',
        'errors' => [
          'required' => 'The username field is required',
          'is_unique' => 'The username field must contain a unique username'
        ]
      ],
      'role_id' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The role field is required'
        ]
      ]
    ];

    $data = $this->request->getPost(array_keys($rules));
    if (!$this->validateData($data, $rules)) {
      return redirect()->back()->with('message', 2)->withInput();
    } else {
      $data = $this->request->getPost();
      $responce = $this->users->createUser($data);
      return redirect()->to('/Users')->with('message', $responce);
    }
  }

  public function update($id)
  {
    $rules = [
      'user_name' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The user name field is required'
        ]
      ],
      'user_lastname' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The last name field is required'
        ]
      ],
      'user_email' => [
        'rules' => 'required|valid_email',
        'errors' => [
          'required' => 'The email field is required',
          'valid_email' => 'The email field must contain a valid email address',
        ]
      ],
      'user_username' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The username field is required',
        ]
      ],
      'role_id' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The role field is required'
        ]
      ]
    ];

    if (!$this->validate($rules)) {
      return redirect()->back()->with('message', 2)->withInput();
    } else {
      $data = $this->request->getPost();
      $responce = $this->users->updateUser($id, $data);
      return redirect()->back()->with('message', $responce);
    }
  }

  public function delete($id)
  {
    $rules = [
      'user_annotation' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The annotation field is required'
        ]
      ]
    ];

    if (!$this->validate($rules)) {
      return redirect()->back()->with('message', 2)->withInput();
    }else{
      $data = [
        'user_id' => $id,
        'user_status' => false,
        'user_annotation' => $this->request->getPost('user_annotation')
      ];
      $responce = $this->users->deleteUser($data);
      return redirect()->to('/Users')->with('message', $responce);
    }
  }
}

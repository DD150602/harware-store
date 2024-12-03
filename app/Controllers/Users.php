<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\RolesModel;

class Users extends BaseController
{
  protected $users;
  protected $roles;
  protected $data = [];

  /**
   * Constructor for the controller.
   * 
   * This constructor initializes the `User` and `RolesModel` models and retrieves 
   * the list of all users and roles. The retrieved data is stored in the `$data` 
   * array to be used in views. This ensures that when the controller is instantiated, 
   * the data for users and roles is already available for rendering.
   */
  public function __construct()
  {
    $this->users = new User();
    $this->roles = new RolesModel();
    $this->data['users'] = $this->users->getAllUsers();
    $this->data['roles'] = $this->roles->getAllRoles();
  }

  /**
   * Display the list of users.
   * 
   * This method renders the `Users/Users` view and passes the `$data` array 
   * containing the list of users and roles retrieved in the constructor. 
   * This view will display the list of users and any related data.
   * 
   * @return \CodeIgniter\HTTP\Response The rendered view for displaying users.
   */
  public function index()
  {
    return view('Users/Users', $this->data);
  }

  /**
   * Display the details of a specific user.
   * 
   * This method retrieves the user details for the specified user ID 
   * and passes the data to the `Users/UserDetails` view for display.
   * 
   * @param int $id The ID of the user whose details are to be displayed.
   * 
   * @return \CodeIgniter\HTTP\Response The rendered view with the user details.
   */
  public function user(int $id)
  {
    $this->data['user'] = $this->users->getUser($id);
    return view('Users/UserDetails', $this->data);
  }

  /**
   * Create a new user in the system.
   * 
   * This method validates the input data for creating a new user. It ensures that all required fields are 
   * filled, that the email and username are unique, and that the email is valid. If the validation passes, 
   * a new user is created and stored in the database. Afterward, the user is redirected to the `/Users` page 
   * with a success or failure message.
   * 
   * Validation Rules:
   * - 'user_name' : Required. The user name field is mandatory.
   * - 'user_lastname' : Required. The last name field is mandatory.
   * - 'user_email' : Required. The email field is mandatory, must be a valid email address, 
   *   and must be unique in the users table.
   * - 'user_password' : Required. The password field is mandatory.
   * - 'user_username' : Required. The username field is mandatory and must be unique.
   * - 'role_id' : Required. The role field is mandatory.
   * 
   * @return \CodeIgniter\HTTP\RedirectResponse A redirect response to the Users page 
   *         with a status message indicating success or failure.
   */
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

  /**
   * Update an existing user's details.
   * 
   * This method validates the input data for updating an existing user's details, ensuring that all required 
   * fields are filled, and that the email and username fields are properly formatted and valid. If the validation 
   * passes, the user's information is updated in the database. Afterward, the user is redirected back with a 
   * success or failure message.
   * 
   * Validation Rules:
   * - 'user_name' : Required. The user name field is mandatory.
   * - 'user_lastname' : Required. The last name field is mandatory.
   * - 'user_email' : Required. The email field is mandatory and must contain a valid email address.
   * - 'user_username' : Required. The username field is mandatory.
   * - 'role_id' : Required. The role field is mandatory.
   * 
   * @param int $id The ID of the user to be updated.
   * 
   * @return \CodeIgniter\HTTP\RedirectResponse A redirect response to the previous page 
   *         with a status message indicating success or failure.
   */
  public function update(int $id)
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

  /**
   * Soft delete a user by updating their status and adding an annotation.
   * 
   * This method validates the input data for deleting a user, ensuring that the 
   * annotation field is provided. If the validation passes, it marks the user as 
   * inactive by updating their `user_status` to `false`, and also records an annotation 
   * explaining the reason for the deletion. Afterward, the user is redirected to the 
   * user list page with a success or failure message.
   * 
   * Validation Rules:
   * - 'user_annotation' : Required. The annotation field is mandatory to provide a reason for the deletion.
   * 
   * @param int $id The ID of the user to be deleted.
   * 
   * @return \CodeIgniter\HTTP\RedirectResponse A redirect response to the users list page with a status message
   *         indicating success or failure.
   */
  public function delete(int $id)
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
    } else {
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

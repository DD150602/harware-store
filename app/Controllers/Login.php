<?php

namespace App\Controllers;

use App\Models\User;

class Login extends BaseController
{
  protected $user;

  /**
   * Constructor
   *
   * @return void
   */
  public function __construct()
  {
    $this->user = new User();
  }

  /**
   * Displays the login page.
   *
   * @return string The rendered login view.
   */
  public function index(): string
  {
    return view('Login');
  }
  /**
   * Handle user login process.
   *
   * This method validates the login form input and processes the login request.
   * If validation fails, the user is redirected back with the entered input.
   * If the login is successful, user session data is set and the user is redirected
   * to the Products page. Otherwise, the user is redirected back to the login page
   * with an error message.
   *
   * - Redirects back to the login form with input data if validation fails.
   * - Redirects to the Products page if login is successful.
   * - Redirects to the login page with an error message if login fails.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse Redirects to the appropriate page based on the login result.
   */
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

      if ($login_info['login']) {
        $this->session->set('login_info', $login_info);
        return redirect()->to('/Products');
      } else {
        return redirect()->to('/')->with('message', $login_info['message']);
      }
    }
  }

  /**
   * Logs out the current user by destroying the session.
   *
   * This method terminates the user session and redirects to the login page.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse Redirects to the login page.
   */
  public function logout()
  {
    $this->session->destroy();
    return redirect()->to('/');
  }
}

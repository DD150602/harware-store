<?php

namespace App\Controllers;

use App\Models\Client;

class Clients extends BaseController
{
  protected $client;
  protected $data = [];

  /**
   * Constructor.
   *
   * @return void
   */
  public function __construct()
  {
    $this->client = new Client();
    $this->data['clients'] = $this->client->getAllClients();
  }

  /**
   * Displays the list of clients.
   *
   * @return \CodeIgniter\HTTP\ResponseInterface
   */
  public function index()
  {
    return view('Clients/Clients', $this->data);
  }

/**
 * Handles the creation of a new client.
 *
 * This function validates input data for creating a new client, ensuring
 * that the client name, phone, and address adhere to specified rules.
 * If validation passes, the client data is saved to the database. 
 * Otherwise, it redirects back with validation errors.
 *
 * Validation rules:
 * - client_name: must be a string and is required.
 * - client_phone: must be numeric, required, a natural number, and unique.
 * - client_address: must be a string.
 *
 * On success, the function redirects back with a success message; 
 * on failure, redirects back with validation errors and input data.
 *
 * @return \CodeIgniter\HTTP\RedirectResponse
 */
  public function newClient()
  {
    $rules = [
      'client_name' => [
        'rules' => 'string|required',
        'errors' => [
          'string' => 'The client name field must contain only letters',
          'required' => 'The client name field is required'
        ],
      ],
      'client_phone' => [
        'rules' => 'numeric|required|is_natural|is_unique[clients.client_phone]',
        'errors' => [
          'numeric' => 'The client phone field must contain only numbers',
          'required' => 'The client phone field is required',
          'is_natural' => 'The client phone field must be a natural number',
          'is_unique' => 'The client phone is already in use'
        ],
      ],
      'client_address' => [
        'rules' => 'string',
        'errors' => ['string' => 'The client address field must contain only letters'],
      ],
    ];

    $dataToValidate = $this->request->getPost(array_keys($rules));
    if (!$this->validateData($dataToValidate, $rules)) {
      return redirect()->back()->with('message', 2)->withInput();
    } else {
      $data = $this->request->getPost();
      $data['client_created_by'] = session('login_info')['user_id'];
      // print_r($data);
      $response = $this->client->createClient($data);
      return redirect()->back()->with('message', $response);
    }
  }

  /**
   * Retrieves a client by id and displays their details.
   *
   * The client model is used to retrieve a client by id, and the
   * client data is passed to the view for display.
   *
   * @param int $id The client id to retrieve.
   *
   * @return \CodeIgniter\HTTP\ResponseInterface
   */
  public function client(int $id)
  {
    $this->data['client'] = $this->client->getClient($id);
    return view('Clients/ClientDetails', $this->data);
  }

  /**
   * Handles the update of a client.
   *
   * This function validates input data for updating a client, ensuring
   * that the client name, phone, and address adhere to specified rules.
   * If validation passes, the client data is saved to the database.
   * Otherwise, it redirects back with validation errors and input data.
   *
   * Validation rules:
   * - client_name: must be a string and is required.
   * - client_phone: must be numeric, required, a natural number, and unique.
   * - client_address: must be a string.
   *
   * On success, the function redirects back with a success message;
   * on failure, redirects back with validation errors and input data.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function update()
  {
    $rules = [
      'client_name' => [
        'rules' => 'string|required',
        'errors' => [
          'string' => 'The client name field must contain only letters',
          'required' => 'The client name field is required'
        ],
      ],
      'client_phone' => [
        'rules' => 'numeric|required|is_natural|is_unique[clients.client_phone]',
        'errors' => [
          'numeric' => 'The client phone field must contain only numbers',
          'required' => 'The client phone field is required',
          'is_natural' => 'The client phone field must be a natural number',
          'is_unique' => 'The client phone is already in use'
        ],
      ],
      'client_address' => [
        'rules' => 'string',
        'errors' => ['string' => 'The client address field must contain only letters'],
      ],
    ];

    $dataToValidate = $this->request->getPost(array_keys($rules));
    if (!$this->validateData($dataToValidate, $rules)) {
      return redirect()->back()->with('message', 2)->withInput();
    } else {
      $data = $this->request->getPost();
      $data['client_created_by'] = session('login_info')['user_id'];
      $response = $this->client->updateClient($data);
      return redirect()->back()->with('message', $response);
    }
  }

  /**
   * Deletes a client by id and redirects back with a message.
   *
   * Calls the deleteClient method of the client model and redirects to
   * the clients page with a message of 1 if the deletion was successful
   * or 2 if it failed.
   *
   * @param int $id The client id to delete.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $id)
  {
    $response = $this->client->deleteClient($id);
    return redirect()->to('/Clients')->with('message', $response);
  }
}

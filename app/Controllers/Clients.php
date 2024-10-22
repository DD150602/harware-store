<?php

namespace App\Controllers;

use App\Models\Client;

class Clients extends BaseController
{
  protected $client;
  protected $data = [];

  public function __construct()
  {
    $this->client = new Client();
    $this->data['clients'] = $this->client->getAllClients();
  }
  public function index()
  {
    return view('Clients/Clients', $this->data);
  }

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
}

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
}

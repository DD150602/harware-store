<?php

namespace App\Controllers;

use App\Models\Client;
use App\Models\Product;

class Sales extends BaseController
{
  protected $client;
  protected $product;
  protected $data = [];

  public function __construct()
  {
    $this->client = new Client();
    $this->product = new Product();
  }
  public function index()
  {
    return view('Sales/Sales');
  }

  public function createView()
  {
    return view('Sales/CreateSale');
  }

  public function clientInfo()
  {
    $data = $this->request->getPost();
    $client = $this->client->getClientByPhone($data);
    if ($client) {
      $this->data['client_info'] = $client;
      $this->data['products'] = $this->product->getAllProducts();
    }

    return view('Sales/CreateSale', $this->data);
  }
}

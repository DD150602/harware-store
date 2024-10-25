<?php

namespace App\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetails;

class Sales extends BaseController
{
  protected $client;
  protected $product;
  protected $sale;
  protected $saleDetails;
  protected $data = [];

  public function __construct()
  {
    $this->client = new Client();
    $this->product = new Product();
    $this->sale = new Sale();
    $this->saleDetails = new SaleDetails();
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

  public function create()
  {
    $dataPost = $this->request->getJSON();

    $dataToSales = [
      'sale_total' => $dataPost->totalAmount,
      'client_id' => $dataPost->clientId,
      'user_id' => session('login_info')['user_id']
    ];

    $sale_id = $this->sale->insert($dataToSales);
    foreach ($dataPost->productList as $product) {
      $product->sale_id = $sale_id;
    }

    $this->saleDetails->insertBatch($dataPost->productList);
    return $this->response->setJSON(['success' => true]);
  }
}

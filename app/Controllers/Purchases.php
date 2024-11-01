<?php

namespace App\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;

class Purchases extends BaseController
{
  protected $purchase;
  protected $data = [];

  public function __construct()
  {
    $this->purchase = new Purchase();
    $this->data['purchases'] = $this->purchase->getAllPurchases();
  }

  public function index()
  {
    return view('Purchases/Purchases', $this->data);
  }

  public function createView()
  {
    return view('Purchases/CreatePurchase');
  }
}

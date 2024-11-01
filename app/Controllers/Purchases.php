<?php

namespace App\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\PurchaseDetails;

class Purchases extends BaseController
{
  protected $purchase;
  protected $purchaseDetails;
  protected $data = [];

  public function __construct()
  {
    $this->purchase = new Purchase();
    $this->purchaseDetails = new PurchaseDetails();
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

  public function purchase($id)
  {
    $this->data['purchase'] = $this->purchase->getPurchase($id);
    $this->data['purchase_details'] = $this->purchaseDetails->getPurchaseDetails($id);
    return view('Purchases/PurchaseDetails', $this->data);
  }
}

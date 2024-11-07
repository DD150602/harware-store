<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\PurchaseDetails;

class Purchases extends BaseController
{
  protected $purchase;
  protected $purchaseDetails;
  protected $supplier;
  protected $products;
  protected $categories;
  protected $data = [];

  public function __construct()
  {
    $this->purchase = new Purchase();
    $this->purchaseDetails = new PurchaseDetails();
    $this->supplier = new Supplier();
    $this->products = new Product();
    $this->categories = new CategoryModel();
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

  public function supplierInfo()
  {
    $dataPost = $this->request->getPost();
    $supplier_info = $this->supplier->getSupplierToPurchase($dataPost);

    if ($supplier_info) {
      $this->data['supplier_info'] = $supplier_info;
      $this->data['categories'] = $this->categories->getCategories();
      $this->data['products'] = $this->products->getAllProducts();
    }
    return view('Purchases/CreatePurchase', $this->data);
  }

  public function create()
  {
    $dataPost = $this->request->getJSON();
    $dataToPurchase = [
      'purchase_total' => $dataPost->totalAmount,
      'supplier_id' => $dataPost->supplierId,
      'user_id' => session('login_info')['user_id']
    ];

    $purchase_id = $this->purchase->insert($dataToPurchase);
    foreach ($dataPost->productList as $product) {
      $productExist = $this->products->getProduct($product->product_id);
      if (!$productExist) {
        unset($product->product_id);
        $newProduct = [
          'product_name' => $product->product_name,
          'product_description' => $product->product_description,
          'product_price' => $product->product_price,
          'product_stock' => $product->product_stock,
          'category_id' => $product->category_id,
          'supplier_id' => $dataPost->supplierId,
          'product_created_by' => session('login_info')['user_id']
        ];
        $product->product_id = $this->products->insert($newProduct);
      }
      $product->purchase_id = $purchase_id;
      $product->purchase_unit_price = $product->product_price;
      $product->purchase_quantity = $product->product_stock;
    }
    $insert = $this->purchaseDetails->insertBatch($dataPost->productList);

    if ($insert) {
      return $this->response->setJSON(['success' => true, 'productList' => $dataPost->productList]);
    } else {
      return $this->response->setJSON(['success' => false]);
    }
  }
}

<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\CategoryModel;

class Products extends BaseController
{
  protected $products;
  protected $categories;
  protected $data = [];

  public function __construct()
  {
    $this->products = new Product();
    $this->categories = new CategoryModel();

    $this->data['products'] = $this->products->getAllProducts();
    $this->data['categories'] = $this->categories->getCategories();
  }
  public function index()
  {
    return view('Products', $this->data);
  }

  public function product($id)
  {

    $this->data['product'] = $this->products->getProduct($id);
    return view('ProductDetails', $this->data);
  }
}

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

  public function update()
  {
    $rules = [
      'product_name' => [
        'rules' => 'string',
        'errors' => ['string' => 'The product name field must contain only letters'],
      ],
      'product_price' => [
        'rules' => 'decimal',
        'errors' => ['decimal' => 'The product price field must contain only numbers'],
      ],
      'product_stock' => [
        'rules' => 'integer|is_natural',
        'errors' => [
          'integer' => 'The product stock field must contain only numbers',
          'is_natural' => 'The product stock field must contain only positive numbers',
        ],
      ],
      'category_name' => ['required']
    ];

    if (!$this->validate($rules)) {
      return redirect()->back()->with('message', 2)->withInput();
    } else {
      $data = [
        'product_id' => $this->request->getPost('product_id'),
        'product_name' => $this->request->getPost('product_name'),
        'product_description' => $this->request->getPost('product_description'),
        'product_price' => $this->request->getPost('product_price'),
        'product_stock' => $this->request->getPost('product_stock'),
        'category_id' => $this->request->getPost('category_name'),
      ];
      $responce = $this->products->updateProduct($data);
      return redirect()->back()->with('message', $responce);
    }
  }

}

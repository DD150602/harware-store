<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\PurchaseDetails;
use Config\Database as ConfigDatabase;

class Purchases extends BaseController
{
  protected $purchase;
  protected $purchaseDetails;
  protected $supplier;
  protected $products;
  protected $categories;
  protected $data = [];

  protected $db;

  /**
   * Constructor for the Controller.
   *
   * Initializes the required models and retrieves data for the `purchases` property.
   * These models are used throughout the controller to handle operations for purchases, 
   * purchase details, suppliers, products, and categories.
   */
  public function __construct()
  {
    $this->purchase = new Purchase();
    $this->purchaseDetails = new PurchaseDetails();
    $this->supplier = new Supplier();
    $this->products = new Product();
    $this->categories = new CategoryModel();
    $this->data['purchases'] = $this->purchase->getAllPurchases();

    $this->db = ConfigDatabase::connect();
  }

  /**
   * Displays the main Purchases page.
   *
   * This method loads the `Purchases/Purchases` view and passes data to it. 
   * The data includes information such as all purchases retrieved in the constructor.
   *
   * @return \CodeIgniter\HTTP\ResponseInterface The rendered view for the Purchases page.
   */
  public function index()
  {
    return view('Purchases/Purchases', $this->data);
  }

  /**
   * Displays the Create Purchase page.
   *
   * This method loads the `Purchases/CreatePurchase` view, which contains a form
   * for creating a new purchase. This form includes fields for selecting a supplier
   * and adding multiple products to the purchase.
   *
   * @return \CodeIgniter\HTTP\ResponseInterface The rendered view for the Create
   * Purchase page.
   */
  public function createView()
  {
    return view('Purchases/CreatePurchase');
  }

  /**
   * Displays the details of a specific purchase.
   *
   * This method retrieves the details of a specific purchase using the provided purchase ID.
   * It fetches the purchase data and its associated purchase details and passes them to the view.
   *
   * @param int $id The ID of the purchase to retrieve.
   * 
   * @return \CodeIgniter\HTTP\ResponseInterface The rendered view displaying the purchase details.
   */
  public function purchase(int $id)
  {
    $this->data['purchase'] = $this->purchase->getPurchase($id);
    $this->data['purchase_details'] = $this->purchaseDetails->getPurchaseDetails($id);
    return view('Purchases/PurchaseDetails', $this->data);
  }

  /**
   * Handles the supplier information retrieval for a purchase.
   *
   * This method retrieves supplier information based on the POST data from the request.
   * If the supplier information is found, it also fetches all categories and products 
   * for creating a purchase. The data is then passed to the "Create Purchase" view.
   *
   * @return \CodeIgniter\HTTP\ResponseInterface The rendered view for creating a purchase.
   */
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

  /**
   * Handles the creation of a purchase and its related details.
   *
   * This method processes a JSON payload containing purchase and product details, 
   * and performs the following steps:
   * - Creates a new purchase record in the database.
   * - Verifies if each product in the purchase exists in the database:
   *   - If the product doesn't exist, a new product record is created.
   *   - If the product exists, its stock is updated by adding the purchased quantity.
   * - Associates the products with the purchase by creating purchase details.
   * - Updates the product stock in the database.
   * - Inserts the purchase details into the database in a batch operation.
   *
   * If the batch insertion of purchase details is successful, it returns a JSON response
   * with a success message and the list of products. Otherwise, it returns an error response.
   *
   * @return \CodeIgniter\HTTP\Response JSON response indicating the success or failure of the operation.
   */
  public function create()
  {
    $dataPost = $this->request->getJSON();

    $this->db->transStart();
    $dataToPurchase = [
      'purchase_total' => $dataPost->totalAmount,
      'supplier_id' => $dataPost->supplierId,
      'user_id' => session('login_info')['user_id']
    ];
    $purchase_id = $this->purchase->insert($dataToPurchase);

    foreach ($dataPost->productList as $product) {
      $productExist = $this->products->getProduct($product->product_id);
      if ($productExist) {
        $new_total_stock = $productExist->product_stock + $product->product_stock;
        $this->products->updateProduct(['product_id' => $product->product_id, 'product_stock' => $new_total_stock]);
      }

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

    $this->db->transComplete();

    if ($this->db->transStatus() === false) {
      return $this->response->setJSON(['success' => false]);
    }

    if ($insert) {
      return $this->response->setJSON(['success' => true, 'productList' => $dataPost->productList]);
    } else {
      return $this->response->setJSON(['success' => false]);
    }
  }
}

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

  /**
   * Constructor for initializing the necessary models and loading initial data.
   *
   * This constructor initializes the following models:
   * - `Client`: Used for client-related operations.
   * - `Product`: Used for product-related operations.
   * - `Sale`: Used for managing sales data.
   * - `SaleDetails`: Used for managing the details of individual sales.
   *
   * Additionally, it fetches all the sales records from the `Sale` model and stores them in the `$data` array under the key `'sales'`.
   * This data will be used later for displaying sales information in views.
   */
  public function __construct()
  {
    $this->client = new Client();
    $this->product = new Product();
    $this->sale = new Sale();
    $this->saleDetails = new SaleDetails();
    $this->data['sales'] = $this->sale->getAllSales();
  }

  /**
   * Display the sales view with the available sales data.
   *
   * This method retrieves the sales data that was populated in the constructor and passes it to the 'Sales/Sales' view.
   * The data is available through the `$this->data` array, which contains information such as all sales records.
   *
   * @return \CodeIgniter\HTTP\ResponseInterface The view for the sales page, populated with the sales data.
   */
  public function index()
  {
    return view('Sales/Sales', $this->data);
  }

  /**
   * Display the details of a specific sale.
   *
   * This method retrieves the sale data and its associated details based on the provided sale ID. 
   * It uses the `getSaleById` method to fetch the sale information and the `getSaleDetailsBySaleId` method 
   * to retrieve the details of the sale, which are then passed to the 'Sales/SaleDetails' view for display.
   *
   * @param int $id The ID of the sale to retrieve.
   * 
   * @return \CodeIgniter\HTTP\ResponseInterface The view showing the sale details, populated with the sale and sale details data.
   */
  public function sales(int $id)
  {
    $this->data['sale'] = $this->sale->getSaleById($id);
    $this->data['sale_details'] = $this->saleDetails->getSaleDetailsBySaleId($id);
    return view('Sales/SaleDetails', $this->data);
  }

  /**
   * Display the view for creating a new sale.
   *
   * This method is responsible for loading and returning the 'Sales/CreateSale' view where the user 
   * can input the necessary data to create a new sale. No data is passed to the view as it's simply 
   * a form for creating a sale.
   *
   * @return \CodeIgniter\HTTP\Response The view for creating a new sale.
   */
  public function createView()
  {
    return view('Sales/CreateSale');
  }

  /**
   * Retrieve and display client information based on phone number for sale creation.
   *
   * This method processes the incoming POST data containing a client's phone number, 
   * retrieves the associated client details from the database, and populates the view 
   * with client information and the list of available products for the sale. 
   * If the client is found, the data is passed to the 'Sales/CreateSale' view for 
   * displaying client-specific details and product options.
   *
   * @return \CodeIgniter\HTTP\Response The 'Sales/CreateSale' view with client info and product data.
   */
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

  /**
   * Create a new sale and update stock based on the provided product list.
   *
   * This method processes the incoming sale data, including the total amount, client ID, 
   * and the list of products with their quantities. It performs the following actions:
   * - Inserts the sale data into the `sales` table.
   * - For each product in the list, checks if the requested quantity exceeds the available stock. 
   *   If so, it returns an error message indicating the available stock.
   * - Updates the product stock in the `products` table based on the sale quantity.
   * - Inserts the sale details (product list) into the `sale_details` table.
   *
   * If the sale is successfully created and all stock updates are made, a success response is returned.
   * If there is an issue with stock, an error message is returned indicating the problem.
   *
   * @return \CodeIgniter\HTTP\Response JSON response indicating success or failure of the operation.
   */
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
      $product_stock = $this->product->getProduct($product->product_id)->product_stock;
      if ($product->sale_quantity > $product_stock) {
        return $this->response->setJSON(['success' => false, 'errorMessage' => "Only $product_stock for product $product->product_name left in stock"]);
      }
      $stock_left = $product_stock - $product->sale_quantity;
      $this->product->update($product->product_id, ['product_stock' => $stock_left]);
      $product->sale_id = $sale_id;
    }

    $this->saleDetails->insertBatch($dataPost->productList);
    return $this->response->setJSON(['success' => true]);
  }
}

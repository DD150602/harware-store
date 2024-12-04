<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\CategoryModel;
use Dompdf\Dompdf;

class Products extends BaseController
{
  protected $products;
  protected $categories;
  protected $data = [];

  /**
   * Constructor method.
   *
   * This method initializes the controller's properties and preloads data for products and categories.
   * It sets up models for handling product and category operations and retrieves all products and
   * categories from the database for use across the controller.
   */
  public function __construct()
  {
    $this->products = new Product();
    $this->categories = new CategoryModel();

    $this->data['products'] = $this->products->getAllProducts();
    $this->data['categories'] = $this->categories->getCategories();
  }
  /**
   * Displays the list of products.
   *
   * @return \CodeIgniter\HTTP\ResponseInterface
   */
  public function index()
  {
    return view('Products', $this->data);
  }

  /**
   * Displays the details of the product with the provided ID.
   *
   * This method retrieves the product with the provided ID from the database and
   * displays its details. The product details are retrieved using the
   * `Product::getProduct` method and stored in the `$this->data['product']`
   * property. The details are then displayed using the `ProductDetails` view.
   *
   * @param int $id The ID of the product to display.
   *
   * @return \CodeIgniter\HTTP\ResponseInterface
   */
  public function product(int $id)
  {

    $this->data['product'] = $this->products->getProduct($id);
    return view('ProductDetails', $this->data);
  }

  /**
   * Displays the list of products filtered by category.
   *
   * This method retrieves the category ID from the post request and
   * retrieves all products from the database that match the category ID.
   * The products are retrieved using the `Product::getAllProducts` method
   * and stored in the `$this->data['products']` property. The products are
   * then displayed using the `Products` view.
   *
   * @return \CodeIgniter\HTTP\ResponseInterface
   */
  public function filtered()
  {
    $filte = $this->request->getPost('filterBy');
    if ($filte == 0) {
      $filte = null;
    }
    $this->data['products'] = $this->products->getAllProducts($filte);
    return view('Products', $this->data);
  }

  /**
   * Generates a PDF of all products with low stock.
   *
   * This method uses the `Dompdf` library to generate a PDF of all products
   * with low stock. The products are retrieved using the
   * `Product::lowStockProducts` method and stored in the `$this->data['products']`
   * property. The PDF is then generated using the `ProductsPdf` view.
   *
   * @return \CodeIgniter\HTTP\ResponseInterface
   */
  public function generatePdf()
  {
    $domPdf = new Dompdf();
    $this->data['products'] = $this->products->lowStockProducts();
    $html = view('ProductsPdf', $this->data);

    $domPdf->loadHtml($html);
    $domPdf->render();
    $domPdf->stream('low_stock_products.pdf', ['Attachment' => false]);
  }

  /**
   * Updates a product in the database.
   *
   * This method validates the incoming request data against the following rules:
   * - The product name field must contain only letters.
   * - The product price field must contain only numbers.
   * - The product stock field must contain only positive numbers.
   * - The category name field is required.
   * If the validation fails, the method redirects back to the previous page
   * with an error message and the input data.
   * If the validation succeeds, the method updates the product in the database
   * and redirects back to the previous page with a success message.
   *
   * @return \CodeIgniter\HTTP\ResponseInterface
   */
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

  /**
   * Deletes a product by marking it as inactive.
   *
   * This method validates the provided input, including an optional product annotation,
   * and updates the product's status to inactive in the database. If the validation fails,
   * it redirects back with an error message. If the operation succeeds, it redirects to the 
   * product list with a success message.
   *
   * @param int $id The ID of the product to be deleted.
   * @return \CodeIgniter\HTTP\RedirectResponse Redirects to the appropriate route based on the operation result.
   */
  public function delete(int $id)
  {
    $rules = [
      'product_annotation' => [
        'rules' => 'string',
        'errors' => ['string' => 'The product annotation field must contain only letters'],
      ]
    ];
    if (!$this->validate($rules)) {
      return redirect()->back()->with('message', 2)->withInput();
    } else {
      $data = [
        'product_id' => $id,
        'product_status' => false,
        'product_annotation' => $this->request->getPost('product_annotation'),
      ];
      $responce = $this->products->deleteProduct($data);
      return redirect()->to('/Products')->with('message', $responce);
    }
  }

/**
 * Creates a new category in the database.
 *
 * This method retrieves the category name from the post request and the user ID from the session,
 * then inserts a new category into the database. Upon success or failure, it redirects back with
 * a status message indicating the result of the operation.
 *
 * @return \CodeIgniter\HTTP\RedirectResponse A redirect response to the previous page with a status message.
 */
  public function newCategory()
  {
    $data = [
      'category_name' => $this->request->getPost('categoryName'),
      'category_created_by' => session('login_info')['user_id']
    ];
    $responce = $this->categories->newCategory($data);
    return redirect()->back()->with('message', $responce);
  }
}

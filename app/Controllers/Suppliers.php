<?php

namespace App\Controllers;

use App\Models\Supplier;

class Suppliers extends BaseController
{
  protected $supplier;
  protected $data = [];

  /**
   * Constructor for initializing the Supplier model and loading all suppliers.
   *
   * This constructor method initializes the `Supplier` model and retrieves all suppliers 
   * from the database using the `getAllSuppliers` method. The list of suppliers is stored 
   * in the `$data` array to be accessed by views or other methods within the controller.
   * 
   */
  public function __construct()
  {
    $this->supplier = new Supplier();
    $this->data['suppliers'] = $this->supplier->getAllSuppliers();
  }

  /**
   * Loads the suppliers view and passes the list of suppliers to the view.
   *
   * This method renders the 'suppliers/suppliers' view and passes the `$data` array,
   * which contains the list of all suppliers retrieved during the class initialization.
   * The data will be used to display supplier information in the view.
   * 
   * @return \CodeIgniter\HTTP\Response The rendered view.
   */
  public function index()
  {
    return view('suppliers/suppliers', $this->data);
  }

  /**
   * Retrieves and displays the details of a specific supplier.
   * 
   * This method accepts the supplier ID, retrieves the supplier information from the
   * database using the `getSupplier` method, and passes the supplier data to the 
   * 'suppliers/supplierDetails' view for display.
   * 
   * @param int $id The ID of the supplier to retrieve.
   * @return \CodeIgniter\HTTP\Response The rendered view with supplier details.
   */
  public function supplier(int $id)
  {
    $this->data['supplier'] = $this->supplier->getSupplier($id);
    return view('suppliers/supplierDetails', $this->data);
  }

  /**
   * Handles the creation of a new supplier.
   * 
   * This method validates the input data for the supplier creation form, ensuring
   * required fields (name, contact, phone) are filled. If validation fails, it redirects
   * back to the form with error messages. Upon successful validation, it inserts the 
   * new supplier into the database and redirects back with a success or failure message.
   * 
   * Validation Rules:
   * - `supplier_name`: Required field.
   * - `supplier_contact`: Required field.
   * - `supplier_phone`: Required field.
   * 
   * @return \CodeIgniter\HTTP\RedirectResponse Redirects back to the supplier creation form
   *         with either a success or failure message.
   */
  public function create()
  {
    $rules = [
      'supplier_name' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The supplier name field is required',
        ]
      ],
      'supplier_contact' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The supplier contact field is required',
        ]
      ],
      'supplier_phone' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The supplier phone field is required',
        ]
      ]
    ];

    $dataImpute = $this->request->getPost(array_keys($rules));
    if (!$this->validateData($dataImpute, $rules)) {
      return redirect()->back()->with('message', 2)->withInput();
    } else {
      $data = $this->request->getPost();
      $data['supplier_created_by'] = session('login_info')['user_id'];
      $response = $this->supplier->createSupplier($data);
      return redirect()->back()->with('message', $response);
    }
  }

  /**
   * Handles the update of an existing supplier.
   * 
   * This method validates the input data for the supplier update form, ensuring
   * that all required fields (name, contact, phone, address) are filled. If validation 
   * fails, it redirects back to the form with error messages. Upon successful validation, 
   * it updates the supplier's information in the database and redirects back with a success 
   * or failure message.
   * 
   * Validation Rules:
   * - `supplier_name`: Required field.
   * - `supplier_contact`: Required field.
   * - `supplier_phone`: Required field.
   * - `supplier_address`: Required field.
   * 
   * @param int $id The ID of the supplier to update.
   * 
   * @return \CodeIgniter\HTTP\RedirectResponse Redirects back to the supplier update form
   *         with either a success or failure message.
   */
  public function update(int $id)
  {
    $rules = [
      'supplier_name' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The supplier name field is required',
        ]
      ],
      'supplier_contact' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The supplier contact field is required',
        ]
      ],
      'supplier_phone' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The supplier phone field is required',
        ]
      ],
      'supplier_address' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'The supplier address field is required',
        ]
      ]
    ];

    $dataImpute = $this->request->getPost(array_keys($rules));
    if (!$this->validateData($dataImpute, $rules)) {
      return redirect()->back()->with('message', 2)->withInput();
    } else {
      $data = $this->request->getPost();
      $response = $this->supplier->updateSupplier($id, $data);
      return redirect()->back()->with('message', $response);
    }
  }

  /**
   * Deletes a supplier by their ID.
   * 
   * This method attempts to delete a supplier based on the provided supplier ID.
   * It then redirects the user back to the suppliers list with a message indicating 
   * whether the deletion was successful or not.
   * 
   * @param int $id The ID of the supplier to delete.
   * 
   * @return \CodeIgniter\HTTP\RedirectResponse Redirects to the suppliers list page with a success or failure message.
   */
  public function delete(int $id)
  {
    $response = $this->supplier->deleteSupplier($id);
    return redirect()->to('Suppliers')->with('message', $response);
  }
}

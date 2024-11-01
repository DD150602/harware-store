<?php

namespace App\Controllers;

use App\Models\Supplier;

class Suppliers extends BaseController
{
  protected $supplier;
  protected $data = [];
  public function __construct()
  {
    $this->supplier = new Supplier();
    $this->data['suppliers'] = $this->supplier->getAllSuppliers();
  }
  public function index()
  {
    return view('suppliers/suppliers', $this->data);
  }

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
}

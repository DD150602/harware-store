<?php

namespace App\Controllers;

class Sales extends BaseController
{
  public function index()
  {
    return view('Sales/Sales');
  }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class Client extends Model
{
  protected $table = 'clients';
  protected $primaryKey = 'client_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $allowedFields = ['client_id', 'client_name', 'client_phone', 'client_address'];
}

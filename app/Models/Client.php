<?php

namespace App\Models;

use CodeIgniter\Model;

class Client extends Model
{
  protected $table = 'clients';
  protected $primaryKey = 'client_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $useSoftDeletes = true;
  protected $allowedFields = ['client_id', 'client_name', 'client_phone', 'client_address'];
  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'client_created_at';
  protected $updatedField = 'client_updated_at';
  protected $deletedField = 'client_deleted_at';
}

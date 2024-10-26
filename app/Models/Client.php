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
  protected $allowedFields = ['client_id', 'client_name', 'client_phone', 'client_address', 'client_created_by'];
  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'client_created_at';
  protected $updatedField = 'client_updated_at';
  protected $deletedField = 'client_deleted_at';

  public function getAllClients()
  {
    return $this->select('client_id, client_name, client_phone, client_address')->findAll();
  }

  public function getClient($id)
  {
    return $this->select('client_id, client_name, client_phone, client_address')
      ->where('client_id', $id)->first();
  }

  public function getClientByPhone(array $data)
  {
    return $this->select('client_id, client_name, client_phone, client_address')
      ->where('client_phone', $data['client_phone'])->first();
  }

  public function createClient(array $data): int
  {
    $insert = $this->insert($data);
    if ($insert) {
      return 1;
    } else {
      return 2;
    }
  }

  public function updateClient(array $data): int
  {
    $clientId = $data['client_id'];
    unset($data['client_id']);
    $update = $this->update($clientId, $data);
    if ($update) {
      return 1;
    } else {
      return 2;
    }
  }

  public function deleteClient($id): int
  {
    $delete = $this->delete($id);
    if ($delete) {
      return 1;
    } else {
      return 2;
    }
  }
}

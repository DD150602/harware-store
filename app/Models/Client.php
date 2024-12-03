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

  /**
   * Retrieve all active clients with basic details.
   * 
   * This method fetches a list of all clients, including their ID, name, phone number, and address.
   * The method ensures that only active clients are retrieved.
   * 
   * @return object[] An array of objects where each object contains the client's ID, name, phone number, and address.
   */
  public function getAllClients()
  {
    return $this->select('client_id, client_name, client_phone, client_address')->findAll();
  }

  /**
   * Retrieves a client by id.
   *
   * The client model is used to retrieve a client by id, and the
   * client data is returned as an object.
   *
   * @param int $id The client id to retrieve.
   *
   * @return object The client object.
   */
  public function getClient(int $id)
  {
    return $this->select('client_id, client_name, client_phone, client_address')
      ->where('client_id', $id)->first();
  }

  /**
   * Retrieves a client by phone number.
   *
   * The client model is used to retrieve a client by phone number, and the
   * client data is returned as an object.
   *
   * @param array $data The data containing the client phone number.
   *
   * @return object The client object.
   */
  public function getClientByPhone(array $data)
  {
    return $this->select('client_id, client_name, client_phone, client_address')
      ->where('client_phone', $data['client_phone'])->first();
  }

  /**
   * Create a new client by inserting their data into the database.
   * 
   * This method inserts the provided client data into the database. If the insertion 
   * is successful, it returns a success code (1). If the insertion fails, it returns 
   * a failure code (2).
   * 
   * @param array $data The client data to be inserted into the database.
   * 
   * @return int A status code indicating the result of the operation:
   *         - 1: Success - The client data was successfully inserted.
   *         - 2: Failure - The client data could not be inserted.
   */
  public function createClient(array $data): int
  {
    $insert = $this->insert($data);
    if ($insert) {
      return 1;
    } else {
      return 2;
    }
  }

  /**
   * Update an existing client's information in the database.
   * 
   * This method updates the client record identified by the provided client ID with the
   * new data passed in the `$data` array. The `client_id` is extracted from the data 
   * array and used to identify the client to update. If the update is successful, it returns
   * a success code (1). If the update fails, it returns a failure code (2).
   * 
   * @param array $data The new data to update the client information. The array must include the 'client_id' field to identify the client.
   * 
   * @return int A status code indicating the result of the operation:
   *         - 1: Success - The client data was successfully updated.
   *         - 2: Failure - The client data could not be updated.
   */
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

  /**
   * Delete a client from the database.
   * 
   * This method deletes the client identified by the given `client_id`. If the deletion
   * is successful, it returns a success code (1). If the deletion fails, it returns a failure
   * code (2).
   * 
   * @param int $id The unique identifier of the client to be deleted.
   * 
   * @return int A status code indicating the result of the operation:
   *         - 1: Success - The client was successfully deleted.
   *         - 2: Failure - The client could not be deleted.
   */
  public function deleteClient(int $id): int
  {
    $delete = $this->delete($id);
    if ($delete) {
      return 1;
    } else {
      return 2;
    }
  }
}

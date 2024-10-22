<?= $this->extend('Templates/Layout') ?>

<?= $this->section('content') ?>

<main class="container mt-5">
  <?php $this->include('Templates/Components/Topbar') ?>
  <h2 class="text-center mb-5">client Details</h2>
  <div class="d-flex justify-content-end">
    <!-- Button to trigger Delete client modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteClientModal">Delete client</button>
  </div>


  <!-- client Details Card -->
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card client-card p-4 mb-5">
        <h2 class="text-center">Details</h2>
        <p><strong>Name:</strong> <?php echo $client->client_name; ?> </p>
        <p><strong>Description:</strong> <?php echo $client->client_phone; ?> </p>
        <p><strong>Price:</strong> <?php echo $client->client_address; ?> </p>
      </div>
    </div>
  </div>

  <!-- Form for Editing client Details -->
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="border border-dark rounded p-4">
        <h4 class="text-center mb-4">Edit client Details</h4>

        <?php echo form_open('/Clients/update'); ?>
        <div class="row g-3">

          <!-- client ID -->
          <input type="hidden" class="form-control" id="client_id" name="client_id" value="<?php echo $client->client_id; ?>">

          <!-- client Name -->
          <div class="col-md-6 mb-3">
            <label for="client_name" class="form-label">Client Name</label>
            <input type="text" class="form-control" id="client_name" name="client_name" value="<?php echo set_value('client_name', $client->client_name); ?>">
            <?php echo validation_show_error('client_name'); ?>
          </div>

          <!-- client Phone -->
          <div class="col-md-6 mb-3">
            <label for="client_phone" class="form-label">Client Phone</label>
            <input type="text" class="form-control" id="client_phone" name="client_phone" value="<?php echo set_value('client_phone', $client->client_phone); ?>">
            <?php echo validation_show_error('client_phone'); ?>
          </div>
          <!-- client Address -->
          <div class="col-md-12 mb-3">
            <label for="client_address" class="form-label">Client Address</label>
            <textarea name="client_address" id="client_address" class="form-control" rows="3" required><?php echo set_value('client_address', $client->client_address); ?></textarea>
            <?php echo validation_show_error('client_address'); ?>
          </div>

          <!-- Submit Button -->
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-dark">Update client</button>
          </div>

        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</main>

<!-- Delete client Modal -->
<div class="modal fade" id="deleteClientModal" tabindex="-1" aria-labelledby="deleteClientModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteClientModalLabel">Delete client</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Delete form -->
        <?php echo form_open('/Clients/delete/' . $client->client_id); ?>
        <p>Are you sure about deleting this client?</p>
        <p>This action canot be undone</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <!-- Submit the form -->
        <button type="submit" class="btn btn-danger">Delete</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>


<?= $this->endSection() ?>
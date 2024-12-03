<?= $this->extend('Templates/Layout') ?>

<?= $this->section('content') ?>

<main class="main-content">
  <?= $this->include('Templates/Components/Topbar') ?>

  <h1 class="mb-4">Clients</h1>
  <div class="d-flex justify-content-between mb-3">
    <form class="d-flex">
      <div class="input-group">
        <input class="form-control" type="text" name="search" id="search" placeholder="Search client">
        <button class="btn btn-primary" type="submit">Search</button>
      </div>
    </form>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newClientModal">New Client</button>
  </div>

  <!-- Clients card list -->
  <section class="row">
    <?php if (!empty($clients)) : ?>
      <?php foreach ($clients as $client) : ?>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title"><?php echo $client->client_name; ?></h5>
              <p class="card-text">
                <strong>Phone:</strong> <?php echo $client->client_phone; ?><br>
                <strong>Address:</strong> <?php echo $client->client_address ? $client->client_address : 'N/A'; ?><br>
              </p>
              <a href="<?php echo base_url('/Clients/ClientDetails/' . $client->client_id); ?>" class="btn btn-outline-primary">Client details</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p class="text-center">No clients found</p>
    <?php endif; ?>
  </section>

</main>

<!-- Modal -->
<div class="modal fade" id="newClientModal" tabindex="-1" aria-labelledby="newClientModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newClientModal">New Client</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php echo form_open('/Clients/create') ?>
        <div class="container">
          <div class="row g-3">
            <!-- Name -->
            <div class="col-md-6">
              <label for="client_name" class="form-label">Name</label>
              <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Enter the name" <?php echo set_value('client_name') ?>>
              <?php echo validation_show_error('client_name'); ?>
            </div>

            <!-- Phone -->
            <div class="col-md-6">
              <label for="client_phone" class="form-label">Phone Numbre</label>
              <input type="text" class="form-control" id="client_phone" name="client_phone" placeholder="Enter Phone number" <?php echo set_value('client_phone') ?>>
              <?php echo validation_show_error('client_phone'); ?>
            </div>

            <!-- Address -->
            <div class="col-md-12">
              <label for="client_address" class="form-label">Address</label>
              <input type="text" class="form-control" id="client_address" name="client_address" placeholder="Enter Address (optional)" <?php echo set_value('client_address') ?>>
              <?php echo validation_show_error('client_address'); ?>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end mt-4">
              <button type="submit" class="btn btn-primary">Create User</button>
            </div>
          </div>
          <?php echo form_close() ?>
        </div>
      </div>
    </div>
  </div>

  <?= $this->endSection() ?>
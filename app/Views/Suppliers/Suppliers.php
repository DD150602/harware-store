<?= $this->extend('Templates/Layout') ?>

<?= $this->section('scripts') ?>
<script type="module">
  let message = <?php echo session('message') ?>;
  if (message === 1) {
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: 'Supplier created successfully'
    })
  } else if (message === 3) {
    Swal.fire({
      icon: 'success',
      title: 'Supplier Deleted Successfully',
      text: 'Supplier deleted successfully'
    })
  } else if (message === 4) {
    Swal.fire({
      icon: 'success',
      title: 'Supplier Restored Successfully',
      text: 'Supplier Restored Successfully',
    })
  }
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<main class="main-content">
  <?= $this->include('Templates/Components/Topbar') ?>

  <h1 class="mb-4">Suppliers</h1>
  <div class="d-flex justify-content-between mb-3">
    <form class="d-flex">
      <div class="input-group">
        <input class="form-control" type="text" name="search" id="search" placeholder="Search supplier">
        <button class="btn btn-primary" type="submit">Search</button>
      </div>
    </form>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newSupplierModal">New Supplier</button>
  </div>

  <!-- Suppliers card list -->
  <section class="row">
    <?php if (!empty($suppliers)) : ?>
      <?php foreach ($suppliers as $supplier) : ?>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title"><?php echo $supplier->supplier_name; ?></h5>
              <p class="card-text">
                <strong>Phone:</strong> <?php echo $supplier->supplier_phone; ?><br>
                <strong>Address:</strong> <?php echo $supplier->supplier_address ? $supplier->supplier_address : 'N/A'; ?><br>
              </p>
              <a href="<?php echo base_url('/Suppliers/SupplierDetails/' . $supplier->supplier_id); ?>" class="btn btn-outline-primary">Supplier details</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p class="text-center">No suppliers found</p>
    <?php endif; ?>
  </section>

</main>

<!-- Modal -->
<div class="modal fade" id="newSupplierModal" tabindex="-1" aria-labelledby="newSupplierModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newSupplierModal">New Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php echo form_open('Suppliers/create') ?>
        <div class="container">
          <div class="row g-3">
            <!-- Name -->
            <div class="col-md-6">
              <label for="supplier_name" class="form-label">Name</label>
              <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Enter the name" <?php echo set_value('supplier_name') ?>>
              <?php echo validation_show_error('supplier_name'); ?>
            </div>

            <!-- Contact -->
            <div class="col-md-6">
              <label for="supplier_contact" class="form-label">Contact</label>
              <input type="text" class="form-control" id="supplier_contact" name="supplier_contact" placeholder="Enter the name" <?php echo set_value('supplier_contact') ?>>
              <?php echo validation_show_error('supplier_contact'); ?>
            </div>

            <!-- Phone -->
            <div class="col-md-6">
              <label for="supplier_phone" class="form-label">Phone Number</label>
              <input type="text" class="form-control" id="supplier_phone" name="supplier_phone" placeholder="Enter phone number" <?php echo set_value('supplier_phone') ?>>
              <?php echo validation_show_error('supplier_phone'); ?>
            </div>

            <!-- Address -->
            <div class="col-md-6">
              <label for="supplier_address" class="form-label">Address</label>
              <input type="text" class="form-control" id="supplier_address" name="supplier_address" placeholder="Enter address (optional)" <?php echo set_value('supplier_address') ?>>
              <?php echo validation_show_error('supplier_address'); ?>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end mt-4">
              <button type="submit" class="btn btn-primary">Create Supplier</button>
            </div>
          </div>
          <?php echo form_close() ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
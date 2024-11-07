<?= $this->extend('Templates/Layout') ?>

<?= $this->section('scripts') ?>
<script type="module">
  let message = <?php echo session('message') ?>;
  if (message === 1) {
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: 'Supplier info updated successfully'
    })
  } else if (message === 2) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Failed to update Supplier info'
    })
  }
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<main class="container mt-5">
  <h2 class="text-center mb-5">Supplier Details</h2>
  <div class="d-flex justify-content-end">
    <!-- Button to trigger Delete supplier modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteSupplierModal">Delete Supplier</button>
  </div>

  <!-- Supplier Details Card -->
  <section class="row justify-content-center">
    <article class="col-md-6">
      <div class="card supplier-card p-4 mb-5">
        <h3 class="text-center">Details</h3>
        <p><strong>Supplier Name:</strong> <?php echo $supplier->supplier_name ?></p>
        <p><strong>Contact:</strong> <?php echo $supplier->supplier_contact; ?></p>
        <p><strong>Phone:</strong> <?php echo $supplier->supplier_phone; ?></p>
        <p><strong>Address:</strong> <?php echo $supplier->supplier_address; ?></p>
      </div>
    </article>
  </section>

  <!-- Form for Editing Supplier Details -->
  <section class="row justify-content-center">
    <article class="col-md-8">
      <?php echo form_open('Suppliers/update/' . $supplier->supplier_id, ['class' => 'border border-dark rounded p-4']); ?>
      <h4 class="text-center mb-4">Edit Supplier Details</h4>

      <div class="row g-3">
        <!-- Supplier First Name -->
        <div class="col-md-6 mb-3">
          <label for="supplier_name" class="form-label">Name</label>
          <input type="text" class="form-control" id="supplier_name" name="supplier_name" value="<?php echo set_value('supplier_name', $supplier->supplier_name); ?>">
          <?php echo validation_show_error('supplier_name'); ?>
        </div>

        <!-- Supplier contact -->
        <div class="col-md-6 mb-3">
          <label for="supplier_contact" class="form-label">Contact</label>
          <input type="text" class="form-control" id="supplier_contact" name="supplier_contact" value="<?php echo set_value('supplier_contact', $supplier->supplier_contact); ?>">
          <?php echo validation_show_error('supplier_contact'); ?>
        </div>

        <!-- Phone -->
        <div class="col-md-6 mb-3">
          <label for="supplier_phone" class="form-label">Phone</label>
          <input type="text" class="form-control" id="supplier_phone" name="supplier_phone" value="<?php echo set_value('supplier_phone', $supplier->supplier_phone); ?>">
          <?php echo validation_show_error('supplier_phone'); ?>
        </div>

        <!-- Address -->
        <div class="col-md-6 mb-3">
          <label for="supplier_address" class="form-label">Address</label>
          <input type="text" class="form-control" id="supplier_address" name="supplier_address" value="<?php echo set_value('supplier_address', $supplier->supplier_address); ?>">
          <?php echo validation_show_error('supplier_address'); ?>
        </div>

        <!-- Submit Button -->
        <div class="col-12 text-center">
          <button type="submit" class="btn btn-dark">Update Supplier</button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </article>
  </section>
</main>

<!-- Delete Supplier Modal -->
<section class="modal fade" id="deleteSupplierModal" tabindex="-1" aria-labelledby="deleteSupplierModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <article class="modal-content">
      <header class="modal-header">
        <h5 class="modal-title" id="deleteSupplierModalLabel">Delete Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </header>
      <div class="modal-body">
        <!-- Delete form -->
        <?php echo form_open('Suppliers/delete/' . $supplier->supplier_id); ?>
        <p>Are you sure about deleting this supplier?</p>
        <p><strong>Supplier Name:</strong> <?php echo $supplier->supplier_name ?></p>
        <p>this action cannot be undone</p>
      </div>
      <footer class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <!-- Submit the form -->
        <button type="submit" class="btn btn-danger">Delete</button>
        <?php echo form_close(); ?>
      </footer>
    </article>
  </div>
</section>

<?= $this->endSection() ?>
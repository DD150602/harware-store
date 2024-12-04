<?php $this->extend('Templates/Layout') ?>

<?php $this->section('scripts'); ?>
<script type="module">
  let message = <?php echo session('message') ?>;
  if (message === 1) {
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: 'category created successfully'
    })
  }
  if (message === 2) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Failed creating category'
    })
  }
</script>
<?php $this->endSection() ?>

<?php $this->section('content'); ?>

<main class="main-content">
  <?= $this->include('Templates/Components/Topbar') ?>
  <h1 class="mb-4">Products</h1>
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
    <!-- Search input -->
    <?php echo form_open('/Products/filtered', ['class' => 'flex-grow-1', 'style' => 'max-width: 300px;']); ?>
    <div class="input-group">
      <input type="text" class="form-control" id="search" name="filterBy" placeholder="Search products" required>
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
    <?php echo form_close(); ?>

    <!-- Generate low inventory PDF -->
    <a href="<?php echo base_url('/Products/pdf') ?>" class="btn btn-primary flex-shrink-0" style="white-space: nowrap;">Generate Low Inventory PDF</a>

    <!-- Category filter -->
    <?php echo form_open('/Products/filtered', ['class' => 'flex-grow-1', 'style' => 'max-width: 300px;']); ?>
    <div class="input-group">
      <select class="form-select" name="filterBy" id="categorySearch">
        <option value="0" selected>All categories</option>
        <?php foreach ($categories as $category) : ?>
          <option value="<?= $category->category_name ?>"><?= $category->category_name ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
    <?php echo form_close(); ?>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newCategoryModal">New Category</button>
  </div>
  <!-- Products card list -->
  <section class="row">
    <?php if (!empty($products)) : ?>
      <?php foreach ($products as $product) : ?>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title"><?php echo $product->product_name; ?></h5>
              <p class="card-text">
                <strong>Price:</strong> $<?php echo $product->product_price; ?><br>
                <strong>In Stock:</strong> <?php echo $product->product_stock; ?><br>
                <strong>Category:</strong> <?php echo $product->category_name; ?><br>
              </p>
              <a href="<?php echo base_url('/Products/ProductDetails/' . $product->product_id); ?>" class="btn btn-outline-primary">Product details</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p class="text-center">No products found.</p>
    <?php endif; ?>
  </section>
</main>

<!-- New Category Modal -->
<div class="modal fade" id="newCategoryModal" tabindex="-1" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newCategoryModalLabel">New Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- New category form -->
        <?php echo form_open('/Products/NewCategory'); ?>
        <div class="mb-3">
          <label for="categoryName" class="form-label">Category Name</label>
          <input type="text" class="form-control" id="categoryName" name="categoryName" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<?php $this->endSection(); ?>
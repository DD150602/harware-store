<?= $this->extend('Templates/Layout') ?>

<?= $this->section('scripts') ?>
<script type="module">
  let message = <?php echo session('message') ?>;
  if (message === 1) {
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: 'Product details updated successfully'
    })
  } else if (message === 2) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Failed to update product details'
    })
  }
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<main class="container mt-5">
  <h2 class="text-center mb-5">Product Details</h2>
  <div class="d-flex justify-content-end">
    <!-- Button to trigger Delete Product modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal">Delete product</button>
  </div>


  <!-- Product Details Card -->
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card product-card p-4 mb-5">
        <h2 class="text-center">Details</h2>
        <p><strong>Product Name:</strong> <?php echo $product->product_name; ?> </p>
        <p><strong>Description:</strong> <?php echo $product->product_description; ?> </p>
        <p><strong>Price:</strong> <?php echo $product->product_price; ?> </p>
        <p><strong>Product Stock:</strong> <?php echo $product->product_stock; ?> </p>
        <p><strong>Supplier:</strong> <?php echo $product->supplier_name; ?> </p>
        <p><strong>Category:</strong> <?php echo $product->category_name; ?> </p>
      </div>
    </div>
  </div>

  <!-- Form for Editing Product Details -->
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="border border-dark rounded p-4">
        <h4 class="text-center mb-4">Edit Product Details</h4>

        <?php echo form_open('/Products/update'); ?>
        <div class="row g-3">

          <!-- Product ID -->
          <input type="hidden" class="form-control" id="product_id" name="product_id" value="<?php echo $product->product_id; ?>">

          <!-- Product Name -->
          <div class="col-md-6 mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo set_value('product_name', $product->product_name); ?>">
            <?php echo validation_show_error('product_name'); ?>
          </div>

          <!-- Product Price -->
          <div class="col-md-6 mb-3">
            <label for="product_price" class="form-label">Product Price</label>
            <input type="number" class="form-control" id="product_price" name="product_price" value="<?php echo set_value('product_price', $product->product_price); ?>">
            <?php echo validation_show_error('product_price'); ?>
          </div>

          <!-- Product Stock -->
          <div class="col-md-6 mb-3">
            <label for="product_stock" class="form-label">Product Stock</label>
            <input type="number" class="form-control" id="product_stock" name="product_stock" value="<?php echo set_value('product_stock', $product->product_stock); ?>">
            <?php echo validation_show_error('product_stock'); ?>
          </div>

          <!-- Product Category -->
          <div class="col-md-6 mb-3">
            <label for="category_name" class="form-label">Category</label>
            <select class="form-select" id="category_name" name="category_name" required>
              <option value="" disabled selected>Select a category</option>
              <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category->category_id; ?>" <?php echo set_select('category_name', $category->category_id, $category->category_id == $product->category_id); ?>>
                  <?php echo $category->category_name; ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?php echo validation_show_error('category_name'); ?>
          </div>

          <!-- Product Description -->
          <div class="col-md-12 mb-3">
            <label for="product_description" class="form-label">Product Description</label>
            <textarea name="product_description" id="product_description" class="form-control" rows="3" required><?php echo set_value('product_description', $product->product_description); ?></textarea>
            <?php echo validation_show_error('product_description'); ?>
          </div>

          <!-- Submit Button -->
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-dark">Update Product</button>
          </div>

        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</main>

<!-- Delete Product Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Delete form -->
        <?php echo form_open('/Products/delete/' . $product->product_id); ?>
        <p>Are you sure about deleting this product?</p>
        <div class="mb-3">
          <label for="product_annotation" class="form-label">Reason for deletion</label>
          <textarea class="form-control" id="product_annotation" name="product_annotation" rows="4" placeholder="Please provide a reason for deletion"></textarea>
        </div>
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
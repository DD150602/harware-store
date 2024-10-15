<?= $this->extend('Templates/Layout') ?>

<?= $this->section('content') ?>

<main class="container mt-5">
  <h2 class="text-center mb-5">Product Details</h2>

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

        <?php echo form_open('product/update/' . $product->product_id); ?>
        <div class="row g-3">

          <!-- Product Name -->
          <div class="col-md-6 mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo set_value('product_name', $product->product_name); ?>" required>
          </div>

          <!-- Product Price -->
          <div class="col-md-6 mb-3">
            <label for="product_price" class="form-label">Product Price</label>
            <input type="number" class="form-control" id="product_price" name="product_price" value="<?php echo set_value('product_price', $product->product_price); ?>" required>
          </div>

          <!-- Product Stock -->
          <div class="col-md-6 mb-3">
            <label for="product_stock" class="form-label">Product Stock</label>
            <input type="number" class="form-control" id="product_stock" name="product_stock" value="<?php echo set_value('product_stock', $product->product_stock); ?>" required>
          </div>

          <!-- Product Category -->
          <div class="col-md-6 mb-3">
            <label for="category_name" class="form-label">Category</label>
            <select class="form-select" id="category_name" name="category_name" required>
              <option value="" disabled selected>Select a category</option>
              <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category->category_id; ?>" <?php echo set_select('category_name', $category->category_id, $category->category_id == $product->category_id); ?> >
                  <?php echo $category->category_name; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Product Description -->
          <div class="col-md-12 mb-3">
            <label for="product_description" class="form-label">Product Description</label>
            <textarea name="product_description" id="product_description" class="form-control" rows="3" required><?php echo set_value('product_description', $product->product_description); ?></textarea>
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


<?= $this->endSection() ?>
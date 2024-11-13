<?php $this->extend('Templates/Layout') ?>

<?php $this->section('content'); ?>

<main class="main-content">
  <?= $this->include('Templates/Components/Topbar') ?>
  <h1 class="mb-4">Products</h1>
  <div class="d-flex justify-content-between mb-3 gap-3">
    <!-- Search input -->
    <?php echo form_open('/Products/filtered', ['class' => 'flex-grow-1', 'style' => 'max-width: 300px;']); ?>
    <div class="input-group mb-3">
      <input type="text" class="form-control" id="search" name="filterBy" placeholder="Search products" required>
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
    <?php echo form_close(); ?>

    <?php echo form_open('/Products/filtered', ['class' => 'flex-grow-1', 'style' => 'max-width: 300px;']); ?>
    <div class="input-group mb-3">
      <select class="form-select" name="filterBy" id="categorySearch">
        <option value=0 selected>All categories</option>
        <?php foreach ($categories as $category) : ?>
          <option value=<?= $category->category_name ?>><?= $category->category_name ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
    <?php echo form_close(); ?>
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

<?php $this->endSection(); ?>
<?php $this->extend('Templates/Layout') ?>

<?php $this->section('content'); ?>

<main class="main-content">
  <?= $this->include('Templates/Components/Topbar') ?>
  <h1 class="mb-4">Products</h1>
  <div class="d-flex justify-content-between mb-3">
    <!-- Search input -->
    <form action="">
      <div class="input-group mb-3">
        <input type="text" class="form-control" id="search" name="search" placeholder="Search products" required>
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
    </form>
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
                <strong>Price:</strong> <?php echo $product->product_price; ?><br>
                <strong>Stock:</strong> <?php echo $product->product_stock; ?><br>
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
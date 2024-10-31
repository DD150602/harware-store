<?= $this->extend('Templates/Layout'); ?>

<?= $this->section('content') ?>

<main class="main-content">
  <?= $this->include('Templates/Components/Topbar') ?>
  <h1 class="mb-4">Purchases</h1>

  <div class="d-flex justify-content-between mb-3">
    <form class="d-flex">
      <div class="input-group">
        <input class="form-control" type="text" name="search" id="search" placeholder="Search Purchases">
        <button class="btn btn-primary" type="submit">Search</button>
      </div>
    </form>
    <a class="btn btn-primary" href="<?php echo base_url('/Purchases/create') ?>">New Purchase</a>
  </div>

  <!-- Purchases card list -->
  <section class="row">
    <?php if (!empty($purchases)) : ?>
      <?php foreach ($purchases as $purchase) : ?>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title">Purchase #<?php echo $purchase->purchase_id; ?></h5>
              <p class="card-text">
                <strong>Total:</strong> <?php echo $purchase->purchase_total; ?><br>
                <strong>Date:</strong> <?php echo $purchase->purchase_date; ?><br>
                <strong>Supplier:</strong> <?php echo $purchase->supplier_name; ?><br>
                <strong>User:</strong> <?php echo $purchase->user_name; ?><br>
              </p>
              <a href="<?php echo base_url('/Purchases/PurchaseDetails/' . $purchase->purchase_id) ?>" class="btn btn-outline-primary">Purchase Details</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p class="text-center">No purchases found.</p>
    <?php endif; ?>
  </section>

</main>

<?= $this->endSection() ?>
<?= $this->extend('Templates/Layout') ?>

<?= $this->section('content') ?>

<main class="main-content">
  <?= $this->include('Templates/Components/Topbar') ?>
  <h1 class="mb-4">Sales</h1>

  <div class="d-flex justify-content-between mb-3">
    <form class="d-flex">
      <div class="input-group">
        <input class="form-control" type="text" name="search" id="search" placeholder="Search Sales">
        <button class="btn btn-primary" type="submit">Search</button>
      </div>
    </form>
    <a class="btn btn-primary" href="<?php echo base_url('/Sales/create') ?>">New Sale</a>
  </div>

  <!-- sales card list -->
  <section class="row">
    <?php if (!empty($sales)) : ?>
      <?php foreach ($sales as $sale) : ?>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title">Sale #<?php echo $sale->sale_id; ?></h5>
              <p class="card-text">
                <strong>Total:</strong> <?php echo $sale->sale_total; ?><br>
                <strong>Date:</strong> <?php echo $sale->sale_date; ?><br>
                <strong>Client:</strong> <?php echo $sale->client_name; ?><br>
                <strong>user:</strong> <?php echo $sale->user_name; ?><br>
              </p>
              <a href="<?php echo base_url('/sales/saleDetails/' . $sale->sale_id) ?>" class="btn btn-outline-primary">sale details</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p class="text-center">No sales found.</p>
    <?php endif; ?>
  </section>

</main>

<?= $this->endSection() ?>
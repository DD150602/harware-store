<?= $this->extend('Templates/Layout') ?>


<?= $this->section('content') ?>

<main class="container mt-5">
  <!-- Details Section -->
  <section class="card mb-4">
    <header class="card-header text-center">
      <h2>Details</h2>
    </header>
    <article class="card-body">
      <p><strong>Purchase No:</strong> <?php echo $sale->sale_id; ?></p>
      <p><strong>Total Price:</strong> <?php echo $sale->sale_total; ?></p>
      <p><strong>Date:</strong> <?php echo $sale->sale_date; ?></p>
      <p><strong>Client:</strong> <?php echo $sale->client_name; ?></p>
      <p><strong>User:</strong> <?php echo $sale->user_name; ?></p>
    </article>
  </section>

  <!-- Products Section -->
  <section class="card">
    <article class="card-body">
      <table class="table table-bordered text-center">
        <thead>
          <tr>
            <th scope="col">Product No</th>
            <th scope="col">Product Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($sale_details as $product) : ?>
            <tr>
              <td><?php echo $product->product_id; ?></td>
              <td><?php echo $product->product_name; ?></td>
              <td><?php echo $product->sale_quantity; ?></td>
              <td><?php echo $product->sale_unit_price; ?></td>
            </tr>
          <?php endforeach; ?>
          <!-- Add more products as necessary -->
        </tbody>
      </table>
    </article>
  </section>

  <!-- Go Back Button -->
  <div class="mt-4 text-center">
    <a href="<?php echo base_url('/Sales') ?>" class="btn btn-secondary">Go Back</a>
  </div>
</main>


<?= $this->endSection() ?>
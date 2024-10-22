<?= $this->extend('Templates/Layout') ?>

<?= $this->section('content') ?>

<main class="main-content">
  <?= $this->include('Templates/Components/Topbar') ?>

  <!-- Title -->
  <h2 class="text-center mb-5">Product Selling Process</h2>

  <!-- Two Sections: User Info and Product Selection -->
  <div class="row">
    <!-- Section 1: Client Information -->
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header">
          Client Information
        </div>
        <div class="card-body">
          <?php $atributes = [];
          if (!empty($client_info)) {
            $atributes['hidden'] = true;
          }
          echo form_open('Sales/clientInfo', $atributes); ?>
          <div class="mb-3">
            <label for="client_name" class="form-label">Client Name</label>
            <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Enter client name" required>
          </div>
          <div class="mb-3">
            <label for="client_phone" class="form-label">Client Phone</label>
            <input type="text" class="form-control" id="client_phone" name="client_phone" placeholder="Enter client phone" required>
          </div>
          <button type="submit" class="btn btn-primary">Search</button>
          <?php echo form_close() ?>

          <?php if (!empty($client_info)) : ?>
            <div class="row">
              <!-- Full Name -->
              <div class="col-md-12 mb-3">
                <label for="client_fullname" class="form-label">Full Name</label>
                <p id="client_fullname" class="form-control"><?php echo $client_info->client_name; ?></p> <!-- Dynamic full name goes here -->
              </div>

              <!-- Phone -->
              <div class="col-md-6 mb-3">
                <label for="client_phone" class="form-label">Phone</label>
                <p id="client_phone" class="form-control"><?php echo $client_info->client_phone; ?></p> <!-- Dynamic phone number goes here -->
              </div>

              <!-- Address -->
              <div class="col-md-6 mb-3">
                <label for="client_address" class="form-label">Address</label>
                <p id="client_address" class="form-control"><?php echo $client_info->client_address; ?></p> <!-- Dynamic address goes here -->
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Section 2: Product Selection -->
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header">
          Select Products
        </div>
        <div class="card-body">
          <form id="addProductForm">
            <div class="mb-3">
              <label for="product_select" class="form-label">Select Product</label>
              <select class="form-select" id="product_select" required <?php echo empty($client_info) ? 'disabled' : ''; ?>>
                <option value="" selected disabled>Select a product</option>
                <?php if (!empty($products)) : ?>
                  <?php foreach ($products as $product) : ?>
                    <option value="<?php echo $product->product_id; ?>"><?php echo $product->product_name; ?> - $<?php echo $product->product_price; ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>

            <!-- Product Quantity -->
            <div class="mb-3">
              <label for="product_quantity" class="form-label">Quantity</label>
              <input type="number" class="form-control" id="product_quantity" name="product_quantity" min="1" required <?php echo empty($client_info) ? 'disabled' : ''; ?>>
            </div>

            <!-- Add Product Button -->
            <div class="d-flex justify-content-end">
              <button type="button" class="btn btn-success" id="addProductBtn" <?php echo empty($client_info) ? 'disabled' : ''; ?>>Add Product</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Product List and Total Amount -->
  <section class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Products Added</h4>
          <ul class="list-group mb-3" id="product_list">
            <!-- Dynamic product items will be added here -->
          </ul>

          <!-- Total -->
          <h5 class="text-end">Total: $<span id="total_amount">0</span></h5>

          <!-- Action Buttons -->
          <div class="d-flex justify-content-between">
            <button class="btn btn-danger" id="cancelSaleBtn" <?php echo empty($client_info) ? 'disabled' : ''; ?>>Cancel Sale</button>
            <button class="btn btn-primary" id="finishSaleBtn" <?php echo empty($client_info) ? 'disabled' : ''; ?>>Finish Sale</button>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>

<?= $this->endSection() ?>
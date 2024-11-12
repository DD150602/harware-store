<?= $this->extend('Templates/Layout') ?>

<?= $this->section('scripts') ?>
<script>
  let totalAmount = 0;
  let totalAmountWithTax = 0;
  const productList = []

  function addProduct() {
    const productSelected = document.getElementById('product_select')
    const optionSelected = productSelected.options[productSelected.selectedIndex]
    const product_id = optionSelected.value
    const productName = optionSelected.text.split('-')[0].trim()
    const sale_unit_price = parseFloat(optionSelected.getAttribute('data-price'))
    const sale_quantity = parseInt(document.getElementById('product_quantity').value)
    const productTotal = sale_unit_price * sale_quantity

    const product = {
      product_id,
      productName,
      sale_unit_price,
      sale_quantity,
      productTotal
    }
    productList.push(product)

    const tableBody = document.getElementById('productTable').getElementsByTagName('tbody')[0]
    const newRow = tableBody.insertRow()

    newRow.innerHTML = `
      <td>${product.productName}</td>
      <td>${product.sale_unit_price}</td>
      <td>${product.sale_quantity}</td>
      <td>${product.productTotal}</td>
    `

    totalAmount += product.productTotal
    totalAmountWithTax = totalAmount + (totalAmount * 0.19)
    document.getElementById('totalPrice').innerHTML = totalAmount
    document.getElementById('totalPriceWithTax').innerHTML = totalAmountWithTax
    document.getElementById('product_quantity').value = 0
    productSelected.selectedIndex = 0
  }

  function finishSelling() {
    if (productList.length > 0) {
      fetch('<?= base_url('Sales/create/newSale') ?>', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            productList,
            totalAmount: parseFloat(document.getElementById('totalPriceWithTax').textContent),
            clientId: '<?php if (!empty($client_info)) echo $client_info->client_id ?>'
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Sale completed successfully'
            })
            document.getElementById('totalPrice').innerHTML = 0
            productList.length = 0
            document.getElementById('productTable').getElementsByTagName('tbody')[0].innerHTML = ''
          } else {
            Swal.fire({
              icon: 'error',
              title: 'error',
              text: data.errorMessage
            })
          }
        })
        .catch(error => {
          Swal.fire({
            icon: 'error',
            title: 'error',
            text: 'Something went wrong Try again later'
          })
        })
    }
  }
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<main class="main-content">
  <?= $this->include('Templates/Components/Topbar') ?>

  <!-- Title -->
  <h2 class="text-center mb-5">Product Selling Process</h2>

  <!-- Two Sections: User Info and Product Selection -->
  <div class="row">
    <!-- Section 1: Client Information -->
    <section class="col-md-6 mb-4">
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
    </section>

    <!-- Section 2: Product Selection -->
    <section class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header">
          Select Products
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label for="product_select" class="form-label">Select Product</label>
            <select class="form-select" id="product_select" name="product_select" required <?php echo empty($client_info) ? 'disabled' : ''; ?>>
              <option value="" selected disabled>Select a product</option>
              <?php if (!empty($products)) : ?>
                <?php foreach ($products as $product) : ?>
                  <option value="<?php echo $product->product_id; ?>" data-price="<?php echo $product->product_price; ?>"><?php echo $product->product_name; ?> - $<?php echo $product->product_price; ?> Stock available: <?php echo $product->product_stock; ?>
                  </option>
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
            <button type="submit" class="btn btn-success" id="addProductBtn" <?php echo empty($client_info) ? 'disabled' : ''; ?> onclick="addProduct()">Add Product</button>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Product List and Total Amount -->
  <section class="row">
    <div class="container mt-4">
      <div class="product-list">
        <h2 class="mb-4">Product List</h2>

        <!-- Bootstrap styled table -->
        <table id="productTable" class="table table-striped table-hover table-bordered">
          <thead class="table-dark">
            <tr>
              <th scope="col">Product Name</th>
              <th scope="col">Price</th>
              <th scope="col">Quantity</th>
              <th scope="col">Total</th>
            </tr>
          </thead>
          <tbody>
            <!-- Dynamic product rows will be added here -->
          </tbody>
        </table>

        <!-- Total Price section -->
        <div class="total-section mt-3">
          <strong class="text-end d-block">Total Price: $<span id="totalPrice" class="ms-2">0.00</span></strong>
          <strong class="text-end d-block">Total Price with Tax: $<span id="totalPriceWithTax" class="ms-2">0.00</span></strong>
        </div>

        <!-- Buttons Section -->
        <div class="button-section d-flex justify-content-between mt-4">
          <button class="btn btn-danger" id="cancelSale">Cancel Sale</button>
          <button class="btn btn-success" id="finishSale" onclick="finishSelling()">Finish Sale</button>
        </div>
      </div>
    </div>
  </section>

</main>

<?= $this->endSection() ?>
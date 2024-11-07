<?= $this->extend('Templates/Layout') ?>

<?= $this->section('scripts') ?>
<script>
  let totalAmount = 0
  const productList = []

  function createProduct() {

    const productName = document.getElementById('new_product_name').value;
    const productDescription = document.getElementById('new_product_description').value;
    const productPrice = parseFloat(document.getElementById('new_product_price').value);
    const productStock = parseInt(document.getElementById('new_product_stock').value);

    if (!productName || isNaN(productPrice) || isNaN(productStock)) {
      alert("Please fill in all required fields with valid values.");
      return;
    }


    const newOption = document.createElement('option');
    newOption.value = `new_${Date.now()}`;
    newOption.textContent = `${productName} - $${productPrice.toFixed(2)}`;
    newOption.setAttribute('data-price', productPrice);

    document.getElementById('product_select').appendChild(newOption);

    document.getElementById('createProductModal').querySelectorAll('input, textarea').forEach(input => input.value = '');
    const modal = bootstrap.Modal.getInstance(document.getElementById('createProductModal'));
    modal.hide();
  }

  function addProduct() {
    const productSelected = document.getElementById('product_select');
    const optionSelected = productSelected.options[productSelected.selectedIndex];

    if (!optionSelected.value) return;

    const product_id = optionSelected.value;
    const productName = optionSelected.text.split('-')[0].trim();
    const unit_price = parseFloat(optionSelected.getAttribute('data-price'));
    const quantity = parseInt(document.getElementById('product_quantity').value);

    if (isNaN(quantity) || quantity <= 0) {
      alert("Please enter a valid quantity.");
      return;
    }

    const productTotal = unit_price * quantity;

    const product = {
      product_id,
      productName,
      unit_price,
      quantity,
      productTotal
    };
    productList.push(product);

    const tableBody = document.getElementById('productTable').getElementsByTagName('tbody')[0];
    const newRow = tableBody.insertRow();

    newRow.innerHTML = `
    <td>${product.productName}</td>
    <td>$${product.unit_price.toFixed(2)}</td>
    <td>${product.quantity}</td>
    <td>$${product.productTotal.toFixed(2)}</td>
  `;

    totalAmount += product.productTotal;
    document.getElementById('totalPrice').innerHTML = totalAmount.toFixed(2);

    document.getElementById('product_quantity').value = 0;
    productSelected.selectedIndex = 0;
  }

  function finishPurchase() {
    if (productList.length > 0) {
      fetch('<?= base_url('/Purchases/create/newPurchase') ?>', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            productList,
            totalAmount: parseFloat(document.getElementById('totalPrice').textContent),
            supplierId: '<?php if (!empty($supplier_info)) echo $supplier_info->supplier_id ?>'
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Purchase completed successfully'
            })
            document.getElementById('totalPrice').innerHTML = 0
            productList.length = 0
            document.getElementById('productTable').getElementsByTagName('tbody')[0].innerHTML = ''
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Purchase failed. Try again.'
            })
          }
        })
        .catch(error => {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Try again later.'
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
  <h2 class="text-center mb-5">Product Purchase Process</h2>

  <!-- Two Sections: Supplier Info and Product Selection -->
  <div class="row">
    <!-- Section 1: Supplier Information -->
    <section class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header">
          Supplier Information
        </div>
        <div class="card-body">
          <?php $attributes = [];
          if (!empty($supplier_info)) {
            $attributes['hidden'] = true;
          }
          echo form_open('Purchases/SupplierInfo', $attributes); ?>
          <div class="mb-3">
            <label for="supplier_name" class="form-label">Supplier Name</label>
            <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Enter supplier name" required>
          </div>
          <div class="mb-3">
            <label for="supplier_phone" class="form-label">Supplier Phone</label>
            <input type="text" class="form-control" id="supplier_phone" name="supplier_phone" placeholder="Enter supplier phone" required>
          </div>
          <button type="submit" class="btn btn-primary">Search</button>
          <?php echo form_close() ?>

          <?php if (!empty($supplier_info)) : ?>
            <div class="row">
              <!-- Full Name -->
              <div class="col-md-12 mb-3">
                <label for="supplier_fullname" class="form-label">Full Name</label>
                <p id="supplier_fullname" class="form-control"><?php echo $supplier_info->supplier_name; ?></p>
              </div>

              <!-- Phone -->
              <div class="col-md-6 mb-3">
                <label for="supplier_phone" class="form-label">Phone</label>
                <p id="supplier_phone" class="form-control"><?php echo $supplier_info->supplier_phone; ?></p>
              </div>

              <!-- Address -->
              <div class="col-md-6 mb-3">
                <label for="supplier_address" class="form-label">Address</label>
                <p id="supplier_address" class="form-control"><?php echo $supplier_info->supplier_address; ?></p>
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
          <!-- Select Product Dropdown -->
          <div class="mb-3">
            <label for="product_select" class="form-label">Select Product</label>
            <select class="form-select" id="product_select" name="product_select" required <?php echo empty($supplier_info) ? 'disabled' : ''; ?>>
              <option value="" selected disabled>Select a product</option>
              <?php if (!empty($products)) : ?>
                <?php foreach ($products as $product) : ?>
                  <option value="<?php echo $product->product_id; ?>" data-price="<?php echo $product->product_price; ?>">
                    <?php echo $product->product_name; ?> - $<?php echo $product->product_price; ?>
                  </option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>

          <!-- Product Quantity -->
          <div class="mb-3">
            <label for="product_quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="product_quantity" name="product_quantity" min="1" required <?php echo empty($supplier_info) ? 'disabled' : ''; ?>>
          </div>

          <!-- Buttons Section: Create Product and Add Product -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- Create Product Button (Triggers Modal) -->
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#createProductModal" <?php echo empty($supplier_info) ? 'disabled' : ''; ?>>
              Create Product
            </button>

            <!-- Add Product Button -->
            <button type="submit" class="btn btn-success" id="addProductBtn" <?php echo empty($supplier_info) ? 'disabled' : ''; ?> onclick="addProduct()">
              Add Product
            </button>
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
        <div class="total-section d-flex justify-content-end mt-3">
          <strong>Total Price: $<span id="totalPrice" class="ms-2">0.00</span></strong>
        </div>

        <!-- Buttons Section -->
        <div class="button-section d-flex justify-content-between mt-4">
          <button class="btn btn-danger" id="cancelPurchase">Cancel Purchase</button>
          <button class="btn btn-success" id="finishPurchase" onclick="finishPurchase()">Finish Purchase</button>
        </div>
      </div>
    </div>
  </section>

</main>

<!-- Create Product Modal -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createProductModalLabel">Create New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="new_product_name" class="form-label">Product Name</label>
          <input type="text" class="form-control" id="new_product_name" required>
        </div>
        <div class="mb-3">
          <label for="new_product_description" class="form-label">Product Description</label>
          <textarea class="form-control" id="new_product_description" rows="3"></textarea>
        </div>
        <div class="mb-3">
          <label for="new_product_price" class="form-label">Product Price</label>
          <input type="number" class="form-control" id="new_product_price" min="0" step="0.01" required>
        </div>
        <div class="mb-3">
          <label for="new_product_stock" class="form-label">Product Stock</label>
          <input type="number" class="form-control" id="new_product_stock" min="0" required>
        </div>
        <div class="mb-3">
          <label for="new_product_category" class="form-label">Product Category</label>
          <select class="form-select" id="new_product_category" required>
            <option value="" disabled selected>Select a category</option>
            <?php if (!empty($categories)) : ?>
              <?php foreach ($categories as $category) : ?>
                <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="createProduct()">Add Product</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>low stock products</title>
</head>

<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #fff;
    color: #000;
  }

  .container {
    max-width: 100%;
    margin: 0 auto;
    padding: 1rem;
  }

  h2 {
    text-align: center;
    margin-bottom: 1.5rem;
    font-size: 24px;
  }

  .table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1rem;
    font-size: 12px;
  }

  .table th,
  .table td {
    padding: 8px 10px;
    text-align: left;
    border: 1px solid #000;
  }

  .table th {
    background-color: #f2f2f2;
    font-weight: bold;
  }

  .table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  .table-container {
    overflow: hidden;
  }
</style>

<body>
  <main class="container">
    <h2 class="text-center mb-4">Product List</h2>

    <!-- Table -->
    <div class="table-container">
      <table class="table">
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Category</th>
            <th>Supplier Name</th>
            <th>Created By</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($products)) : ?>
            <?php foreach ($products as $product) : ?>
              <tr>
                <td><?= $product->product_name ?></td>
                <td><?= $product->product_description ?></td>
                <td><?= $product->product_price ?></td>
                <td><?= $product->product_stock ?></td>
                <td><?= $product->category_name ?></td>
                <td><?= $product->supplier_name ?></td>
                <td><?= $product->user ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>


</body>

</html>
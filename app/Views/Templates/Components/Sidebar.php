  <!-- Sidebar -->
  <aside class="col-md-3 col-lg-2 bg-light p-4 shadow-sm">
    <div class="d-flex align-items-center mb-4">
      <span class="fw-bold h5">B.T.S</span>
    </div>

    <nav class="nav flex-column">
      <!-- Products -->
      <a href="<?= base_url('Products') ?>" class="nav-link text-dark py-2">Products</a>

      <!-- Products -->
      <a href="<?= base_url('Sales') ?>" class="nav-link text-dark py-2">Sales</a>

      <!-- Settings -->
      <a href="" class="nav-link text-dark py-2">Settings</a>

      <!-- Logout -->
      <hr class="my-3"> <!-- Divider -->
      <a href="<?php echo base_url('logout'); ?>" class="nav-link text-danger py-2">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </nav>
  </aside>
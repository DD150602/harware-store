<?= $this->extend('Templates/Layout') ?>

<?= $this->section('scripts') ?>
<script type="module">
  let message = <?php echo session('message') ?>;
  if (message === 1) {
    Swal.fire({
      icon: 'error',
      title: 'Email not found',
      text: 'The email may not exist in the sistem, check it and try again'
    })
  } else if (message === 2) {
    Swal.fire({
      icon: 'error',
      title: 'Incorrect password',
      text: 'Check the password and try again'
    })
  }
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="col-md-6">
    <div class="card shadow-lg">
      <div class="card-body p-5">
        <h2 class="text-center mb-4">Login</h2>

        <!-- Login Form -->
        <?= form_open('login') ?>
        <div class="mb-3">
          <label for="user_email" class="form-label">Email</label>
          <input type="user_email" class="form-control" id="user_email" name="user_email" placeholder="Enter your email" value="<?php echo set_value('user_email'); ?>">
          <?php echo validation_show_error('user_email'); ?>
        </div>

        <div class="mb-3">
          <label for="user_password" class="form-label">Password</label>
          <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Enter your password" value="<?php echo set_value('user_password'); ?>">
          <?php echo validation_show_error('user_password'); ?>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-dark btn-block">Login</button>
        </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
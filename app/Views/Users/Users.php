<?= $this->extend('Templates/Layout') ?>

<?= $this->section('content') ?>

<main class="main-content">
  <?= $this->include('Templates/Components/Topbar') ?>
  <h1 class="mb-4">Users</h1>
  <div class="d-flex justify-content-between mb-3">
    <form>
      <div class="input-group mb-3">
        <input class="form-control" type="text" name="search" id="search" placeholder="Search users">
        <button class="btn btn-primary" type="submit">Search</button>
      </div>
    </form>
  </div>

  <!-- Users card list -->
  <section class="row">
    <?php if (!empty($Users)) : ?>
      <?php foreach ($Users as $user) : ?>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title"><?php echo $user->user_name; ?></h5>
              <p class="card-text">
                <strong>Role:</strong> <?php echo $user->role_name; ?><br>
                <strong>Date Added:</strong> <?php echo $user->user_created_at; ?><br>
              </p>
              <a href="<?php echo base_url('/Users/UserDetails/' . $user->user_id); ?>" class="btn btn-outline-primary">user details</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p class="text-center">No Users found.</p>
    <?php endif; ?>
  </section>

</main>

<?= $this->endSection() ?>
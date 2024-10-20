<?= $this->extend('Templates/Layout') ?>

<?= $this->section('scripts') ?>
<script type="module">
  let message = <?php echo session('message') ?>;
  if (message === 1) {
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: 'User created successfully'
    })
  } else if (message === 2) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Failed creating user'
    })
  } else if (message === 3) {
    Swal.fire({
      icon: 'error',
      title: 'Invalid username',
      text: 'The username is alreay taken, try another one'
    })
  } else if (message === 4) {
    Swal.fire({
      icon: 'error',
      title: 'Invalid email',
      text: 'The email is alreay taken, try another one'
    })
  }
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<main class="main-content">
  <?= $this->include('Templates/Components/Topbar') ?>
  <h1 class="mb-4">Users</h1>
  <div class="d-flex justify-content-between mb-3">
    <form class="d-flex">
      <div class="input-group">
        <input class="form-control" type="text" name="search" id="search" placeholder="Search users">
        <button class="btn btn-primary" type="submit">Search</button>
      </div>
    </form>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newUserModal">New User</button>
  </div>


  <!-- Users card list -->
  <section class="row">
    <?php if (!empty($users)) : ?>
      <?php foreach ($users as $user) : ?>
        <?php if ($user->role_name == 'Superadmin') : ?>
          <!-- <p class="text-center">No Users found.</p> -->
          <?php continue; ?>
        <?php else : ?>
          <div class="col-md-4">
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title"><?php echo $user->user_name; ?></h5>
                <p class="card-text">
                  <strong>Role:</strong> <?php echo $user->role_name; ?><br>
                  <strong>Date Added:</strong> <?php echo $user->user_created_at; ?><br>
                </p>
                <a href="<?php echo base_url('/Users/UserDetails/' . $user->user_id) ?>" class="btn btn-outline-primary">user details</a>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php else : ?>
      <p class="text-center">No Users found.</p>
    <?php endif; ?>
  </section>

</main>

<!-- Modal -->
<div class="modal fade" id="newUserModal" tabindex="-1" aria-labelledby="newUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newUserModalLabel">New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php echo form_open('/Users/create') ?>
        <div class="container">
          <div class="row g-3">
            <!-- First Name -->
            <div class="col-md-6">
              <label for="user_name" class="form-label">First Name</label>
              <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter first name" <?php echo set_value('user_name') ?>>
              <?php echo validation_show_error('user_name'); ?>
            </div>

            <!-- Last Name -->
            <div class="col-md-6">
              <label for="user_lastname" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="user_lastname" name="user_lastname" placeholder="Enter last name" <?php echo set_value('user_lastname') ?>>
              <?php echo validation_show_error('user_lastname'); ?>
            </div>

            <!-- Email -->
            <div class="col-md-12">
              <label for="user_email" class="form-label">Email</label>
              <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Enter email" <?php echo set_value('user_email') ?>>
              <?php echo validation_show_error('user_email'); ?>
            </div>

            <!-- Username -->
            <div class="col-md-6">
              <label for="user_username" class="form-label">Username</label>
              <input type="text" class="form-control" id="user_username" name="user_username" placeholder="Enter username" <?php echo set_value('user_username') ?>>
              <?php echo validation_show_error('user_username'); ?>
            </div>

            <!-- Password -->
            <div class="col-md-6">
              <label for="user_password" class="form-label">Password</label>
              <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Enter password" <?php echo set_value('user_password') ?>>
              <?php echo validation_show_error('user_password'); ?>
            </div>

            <!-- Role -->
            <div class="col-md-12">
              <label for="role_id" class="form-label">Role</label>
              <select class="form-control" id="role_id" name="role_id" <?php echo set_value('role_id') ?>>
                <option value="" disabled selected>Select a role</option>
                <?php foreach ($roles as $role): ?>
                  <option value="<?php echo $role->role_id; ?>"><?php echo $role->role_name; ?></option>
                <?php endforeach; ?>
              </select>
              <?php echo validation_show_error('role_id'); ?>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary">Create User</button>
          </div>
        </div>
        <?php echo form_close() ?>
      </div>
    </div>
  </div>
</div>


<?= $this->endSection() ?>
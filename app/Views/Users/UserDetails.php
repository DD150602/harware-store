<?= $this->extend('Templates/Layout') ?>

<?= $this->section('scripts') ?>
<script type="module">
  let message = <?php echo session('message') ?>;
  if (message === 1) {
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: 'User info updated successfully'
    })
  } else if (message === 2) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Failed to update user info'
    })
  }
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<main class="container mt-5">
  <h2 class="text-center mb-5">User Details</h2>
  <div class="d-flex justify-content-end">
    <!-- Button to trigger Delete user modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal">Delete User</button>
  </div>

  <!-- User Details Card -->
  <section class="row justify-content-center">
    <article class="col-md-6">
      <div class="card user-card p-4 mb-5">
        <h3 class="text-center">Details</h3>
        <p><strong>User Name:</strong> <?php echo $user->user_name . ' ' . $user->user_lastname; ?></p>
        <p><strong>Email:</strong> <?php echo $user->user_email; ?></p>
        <p><strong>Username:</strong> <?php echo $user->user_username; ?></p>
        <p><strong>Role:</strong> <?php echo $user->role_name; ?></p>
      </div>
    </article>
  </section>

  <!-- Form for Editing User Details -->
  <section class="row justify-content-center">
    <article class="col-md-8">
      <?php echo form_open('/Users/update/' . $user->user_id, ['class' => 'border border-dark rounded p-4']); ?>
      <h4 class="text-center mb-4">Edit User Details</h4>

      <div class="row g-3">
        <!-- User First Name -->
        <div class="col-md-6 mb-3">
          <label for="user_name" class="form-label">First Name</label>
          <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo set_value('user_name', $user->user_name); ?>">
          <?php echo validation_show_error('user_name'); ?>
        </div>

        <!-- User Last Name -->
        <div class="col-md-6 mb-3">
          <label for="user_lastname" class="form-label">Last Name</label>
          <input type="text" class="form-control" id="user_lastname" name="user_lastname" value="<?php echo set_value('user_lastname', $user->user_lastname); ?>">
          <?php echo validation_show_error('user_lastname'); ?>
        </div>

        <!-- User Email -->
        <div class="col-md-6 mb-3">
          <label for="user_email" class="form-label">Email</label>
          <input type="email" class="form-control" id="user_email" name="user_email" value="<?php echo set_value('user_email', $user->user_email); ?>">
          <?php echo validation_show_error('user_email'); ?>
        </div>

        <!-- Username -->
        <div class="col-md-6 mb-3">
          <label for="user_username" class="form-label">Username</label>
          <input type="text" class="form-control" id="user_username" name="user_username" value="<?php echo set_value('user_username', $user->user_username); ?>">
          <?php echo validation_show_error('user_username'); ?>
        </div>

        <!-- User Role -->
        <div class="col-md-6 mb-3">
          <label for="role_name" class="form-label">Role</label>
          <select class="form-select" id="role_id" name="role_id" required>
            <option value="" disabled selected>Select a role</option>
            <?php foreach ($roles as $role): ?>
              <option value="<?php echo $role->role_id; ?>" <?php echo set_select('role_name', $role->role_id, $role->role_id == $user->role_id); ?>>
                <?php echo $role->role_name; ?>
              </option>
            <?php endforeach; ?>
          </select>
          <?php echo validation_show_error('role_id'); ?>
        </div>

        <!-- Submit Button -->
        <div class="col-12 text-center">
          <button type="submit" class="btn btn-dark">Update User</button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </article>
  </section>
</main>

<!-- Delete User Modal -->
<section class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <article class="modal-content">
      <header class="modal-header">
        <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </header>
      <div class="modal-body">
        <!-- Delete form -->
        <?php echo form_open('/Users/delete/' . $user->user_id); ?>
        <p>Are you sure about deleting this user?</p>
        <div class="mb-3">
          <label for="user_annotation" class="form-label">Reason for deletion</label>
          <textarea class="form-control" id="user_annotation" name="user_annotation" rows="4" placeholder="Please provide a reason for deletion"></textarea>
        </div>
      </div>
      <footer class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <!-- Submit the form -->
        <button type="submit" class="btn btn-danger">Delete</button>
        <?php echo form_close(); ?>
      </footer>
    </article>
  </div>
</section>


<?= $this->endSection() ?>
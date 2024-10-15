<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="<?= base_url('resources/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('resources/css/sweetalert2.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('resources/main.css') ?>">
  <script defer src="<?= base_url('resources/js/bootstrap.bundle.min.js') ?>"></script>
  <script defer src="<?= base_url('resources/js/popper.min.js') ?>"></script>
  <script defer src="<?= base_url('resources/js/sweetalert2.all.min.js') ?>"></script>

  <?= $this->renderSection('scripts') ?>
</head>

<body>

  <?= $this->renderSection('content') ?>

</body>

</html>
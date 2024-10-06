<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="<?= base_url('resources/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('resources/css/sweetalert.min.css') ?>">
  <script defer type="module" src="<?= base_url('resources/js/bootstrap.bundle.min.js') ?>"></script>
  <script defer type="module" src="<?= base_url('resources/js/popper.min.js') ?>"></script>
  <script defer type="module" src="<?= base_url('resources/js/sweetalert.all.min.js') ?>"></script>
</head>

<body>

  <?= $this->renderSection('content') ?>

</body>

</html>
<?php

use Core\Session;

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" type="text/css" href="<?= STATIC_FILES; ?>build/css/style.css">
  <link rel="stylesheet" type="text/css" href="<?= STATIC_FILES; ?>build/css/all.css">

  <title>GIDIG.IN | Travel Service On Your Pocket </title>
</head>

<body id="home">

  <?php include 'main_menu.php'; ?>
  <?= Session::displayMessage();  ?>
  <?= $this->content("body") ?>

  <script type="text/javascript" src="<?= STATIC_FILES; ?>build/scripts/script.js"></script>
</body>

</html>
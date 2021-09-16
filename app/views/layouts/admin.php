<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>GIDIG.IN | Travel Service On Your Pocket</title>
  <link rel="stylesheet" type="text/css" href="<?= STATIC_FILES; ?>build/css/style.css">
  <link rel="stylesheet" type="text/css" href="<?= STATIC_FILES; ?>build/css/all.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body id="dashboard-page">
  <section id="dashboard">

    <?php include 'admin_sidebar.php'; ?>

    <content id="dashboard-content">

      <?php include 'admin_nav.php'; ?>

      <?= $this->content("body") ?>

    </content>

  </section>

  <script type="text/javascript" src="<?= STATIC_FILES; ?>build/scripts/dashboard.js"></script>
</body>

</html>
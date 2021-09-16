<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php

use Core\Helpers;
use App\Models\Users;

?>

<?php $this->start('body'); ?>

<section id="user-profile" class="container">

  <div class="user-card card">
    <h1>Hi, <?= $this->user->first_name; ?></h1>
    <div class="user-label">
      <p class="key">Name</p>
      <p class="value"><?= $this->user->displayFullName(); ?></p>
    </div>
    <div class="user-label">
      <p class="key">Email</p>
      <p class="value"><?= $this->user->email; ?></p>
    </div>
    <div class="user-action">
      <div>
        <?php if (Users::currentUser()->isSuperAdmin()) : ?>
          <a href="<?= PROJECT_ROOT; ?>admin" class="btn btn-lg">Dashboard</a>
        <?php endif; ?>
        <a href="#" class="btn btn-lg">Edit Profile</a>
      </div>
      <a href="<?= PROJECT_ROOT; ?>user/logout" class="btn btn-lg btn-dark">Logout</a>
    </div>
  </div>

</section>



<?php $this->end(); ?>
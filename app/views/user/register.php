<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php

use Core\FormHelpers;
use Core\Helpers;
?>

<?php $this->start('body'); ?>

<section id="register" class="container">
  <div class="register-form card shadow ">
    <h1 class="register-header"> Register </h1>


    <form method="POST" action="<?= PROJECT_ROOT ?>user/register">
      <div class="form-group">
        <?= FormHelpers::csrf_input(); ?>
      </div>
      <div class="form-group">
        <label for="username">Username</label>
        <input id="username" value="<?= $this->newUser->username; ?>" name="username" placeholder="Username here" class="form-control" type="text">
      </div>
      <div class="form-group">
        <label for="first_name">First Name</label>
        <input id="first_name" value="<?= $this->newUser->first_name; ?>" name="first_name" placeholder="First Name" class="form-control" type="text">
      </div>
      <div class="form-group">
        <label for="last_name">Last Name</label>
        <input id="last_name" name="last_name" value="<?= $this->newUser->last_name; ?>" placeholder="Last Name" class="form-control" type="text">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input id="email" name="email" class="form-control" value="<?= $this->newUser->email; ?>" type="email">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input id="password" name="password" class="form-control" value="<?= $this->newUser->password; ?>" type="password">
      </div>
      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input id="confirm_password" name="confirm_password" class="form-control" type="password">
      </div>
      <div class="form-group">
        <button class="btn btn-lg btn-block btn-dark">Register</button>
      </div>
      <p>You already have an account ? <a href="<?= PROJECT_ROOT; ?>user/login"> Login </a></p>
    </form>
  </div>
  <?= FormHelpers::parseErrorToFormFields($this->displayErrors); ?>
</section>




<?php $this->end(); ?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php 
  use Core\FormHelpers;


 ?>

<?php $this->start('body'); ?>

<section id="login" class="container">
  <div class="login-form card shadow ">
    <h1 class="login-header"> Login </h1>
    <form method="POST" action="<?= PROJECT_ROOT; ?>user/login">
      <div class="form-group">
       <?= FormHelpers::csrf_input(); ?>
      </div>      
      <div class="form-group" >
        <label for="username">Username</label>
        <input id="username" value="<?= $this->login->username; ?>" name="username" placeholder="Username here" class="form-control" type="text">
      </div>
      <div class="form-group" >
        <label for="password">Password</label>
        <input id="password" name="password" value="<?= $this->login->password; ?>" class="form-control" type="password">
      </div>
      <div class="form-group">
        <button class="btn btn-lg btn-block btn-dark">Login</button>
      </div>
    </form>
  </div>
  <?= FormHelpers::parseErrorToFormFields($this->displayErrors); ?>
</section>




<?php $this->end(); ?>

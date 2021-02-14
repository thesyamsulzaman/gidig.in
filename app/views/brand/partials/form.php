<?php 

use Core\Helpers;
use Core\FormHelpers;

 ?>

<form action="<?= $this->formAction; ?>" method="POST" enctype="multipart/form-data">

  
  <div class="form-group">
    <label for="name">Nama Brand</label>
    <input id="name" name="name" value="<?= $this->brand->name; ?>" class="form-control" type="text">
  </div>

  <div class="form-group">
    <input class="btn btn-lg btn-block btn-dark" type="submit" value="Simpan"/>
  </div>
  
  <div class="form-group">
     <?= FormHelpers::csrf_input(); ?>
  </div>


</form>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php 

use Core\Helpers;
use Core\FormHelpers;

?>

<?php $this->start('body'); ?>

 <section id="add-product" class="content-container">

  <div class="navigator">
    <a href="<?= PROJECT_ROOT; ?>product" class="">
	    <i class="fas fa-arrow-left"></i>
	    Kembali
  	</a>
  </div>
  
  <div class="content-form card shadow">
  	<?php $this->partial('product','form') ?>
  </div>

  <?= FormHelpers::parseErrorToFormFields($this->displayErrors); ?>
</section>

<?php $this->end(); ?>

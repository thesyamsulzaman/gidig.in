<?php 

use Core\Helpers;
use Core\FormHelpers;

?>

<div class="form-group">
	<label>Product Images Order</label>
  <div class="sortable-images">
		<?php foreach ($this->images as $image) : ?>
			<div class="sortable-image" draggable="true">
			 <img width="200" src="<?= PROJECT_ROOT . DS .  $image->url ?>">
			</div>
		<?php endforeach; ?>
  </div>
</div>


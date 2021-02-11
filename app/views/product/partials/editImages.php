<?php 

use Core\Helpers;
use Core\FormHelpers;

?>

<div class="form-group">
	<?php foreach ($this->images as $image) : ?>
		<img width="200" src="<?= PROJECT_ROOT . DS .  $image->url ?>">
	<?php endforeach; ?>
</div>


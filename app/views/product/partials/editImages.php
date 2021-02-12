<?php 

use Core\Helpers;
use Core\FormHelpers;

?>

<div class="form-group">
	<label>Product Images Order</label>
  <div class="sortable-images">
		<?php foreach ($this->images as $image) : ?>
			<div class="sortable-image" draggable="true" id="image_<?= $image->id; ?>">
			 <img width="200" src="<?= PROJECT_ROOT . DS .  $image->url ?>">
			</div>
		<?php endforeach; ?>
  </div>
</div>

<script type="text/javascript" defer>

	function getImageIds() {
		const images = document.querySelectorAll(".sortable-image");
		const imageIds = [];

		images.forEach(image => {
			imageIds.push(image.id);
		})

		updateImageIds().value = imageIds;

		return imageIds;
	}

	function updateImageIds() {
		const imagesSorted = document.querySelector("#images_sorted");
		// console.log(imagesSorted.value);
		return imagesSorted;
	}

	
</script>


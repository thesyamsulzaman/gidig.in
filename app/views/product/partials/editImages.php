<?php 

use Core\Helpers;
use Core\FormHelpers;

?>

<div class="form-group">
	<label>Product Images Order</label>
  <div class="sortable-images">
		<?php foreach ($this->images as $image) : ?>
			<div class="sortable-image" draggable="true" id="image_<?= $image->id; ?>">
       <i class="fas fa-times-circle sortable-image_delete" onclick="deleteImage(<?= $image->id; ?>);return 0;"></i>
			 <img width="200" src="<?= PROJECT_ROOT . DS .  $image->url ?>">
			</div>
		<?php endforeach; ?>
  </div>
</div>

<script type="text/javascript" defer>

	function deleteImage(id) {
		if (window.confirm("Apakah anda yakin ? ")) {

      $data = new FormData();
      $data.append("image_id", id);

      fetch(`<?= PROJECT_ROOT; ?>product/deleteImage`, {
        method: "POST",
        mode: "same-origin",
        credentials: "same-origin",
        headers: {
          "Content-Type": "application/json"
        },
        body:JSON.stringify({ id })
      })
      .then(response => response.json())
      .then(data => {
      	document.querySelector(`#image_${id}`).remove();
      	setImageIds();
      })
    }
	}

	function setImageIds() {
		const images = document.querySelectorAll(".sortable-image");
		const imagesSorted = document.querySelector("#images_sorted");
		const imageIds = [];

		images.forEach(image => {
			imageIds.push(image.id);
		})

		imagesSorted.value = JSON.stringify(imageIds);

		return imageIds;
	}

	function getImageIds() {
		const imagesSorted = document.querySelector("#images_sorted");
		return imagesSorted;
	}

	setImageIds();

	
</script>


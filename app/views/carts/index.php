<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php 

use Core\Helpers;

?>

<?php $this->start('body'); ?>

  <section id="shopping-cart" class="container">

  	<h1 class="shopping-cart-header">Cart</h1>

    <div class="shopping-cart-body" border="1">
    	<ul class="shopping-cart-body-list">
		     <?php foreach($this->items as $item): ?>
		     	<hr>
		     	<li class="shopping-cart-body-list-item">
		     		<div class="shopping-cart-body-list-item-image">
		        	<img src="<?= PROJECT_ROOT . $item->url; ?>">
		     		</div>

		     		<div class="shopping-cart-body-list-item-info">
		     			<a href="<?= PROJECT_ROOT; ?>products/detail/<?= $item->product_id; ?>" class="shopping-cart-body-list-item-info-name">
		     				<?= $item->product_name; ?>
		     			</a>
		     			<a href="" class="shopping-cart-body-list-item-info-brand">
		     				<?= $item->brand_name; ?>
		     			</a>
		     			<p class="shopping-cart-body-list-item-info-price">
		     				Rp. <?= $item->product_price; ?>
		     			</p>
		     		</div>

		     		<div class="shopping-cart-body-list-item-quantity">
		     			<p><?= $item->quantity; ?></p>
		     		</div>
		     	</li>
		     <?php endforeach; ?>
    	</ul>
    </div>


  </section>

<?php $this->end(); ?>

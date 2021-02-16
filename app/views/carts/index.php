<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php 

use Core\Helpers;

?>

<?php $this->start('body'); ?>

  <section id="shopping-cart" class="container">

  	<h1 class="shopping-cart-header">Cart <span>(<?= $this->itemCount; ?>)</span></h1>

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
		     			<a href="<?= PROJECT_ROOT; ?>cart/changeQuantity/down/<?= $item->id; ?>" ><i class="fas fa-chevron-down"></i></a>
		     			<p><?= $item->quantity; ?></p>
		     			<a href="<?= PROJECT_ROOT; ?>cart/changeQuantity/up/<?= $item->id; ?>" ><i class="fas fa-chevron-up"></i></a>
		     		</div>
		     	</li>
		     <?php endforeach; ?>
    	</ul>

    	<div class="shopping-cart-body-checkout card">

    		<p class="shopping-cart-body-checkout-header">
    			Ringkasan
    		</p>

    		<hr />

    		<div class="shopping-cart-body-checkout-body">
					<div class="shopping-cart-body-checkout-body-items">
						<p>Total Jumlah</p>
						<p>Rp. <?= $this->subTotal; ?></p>
					</div>

					<div class="shopping-cart-body-checkout-body-shipping">
						<p>Ongkir</p>
						<p>Rp. <?= $this->shippingTotal; ?></p>
					</div>

					<hr />
					<div class="shopping-cart-body-checkout-body-total">
						<p>Total</p>
						<p>Rp. <?= $this->grandTotal; ?></p>
					</div>
    		</div>

    		<div class="shopping-cart-body-checkout-proceed">
    			<button class="btn btn-lg btn-block btn-dark">Checkout</button>
    		</div>


    	</div>


    </div>


  </section>

<?php $this->end(); ?>

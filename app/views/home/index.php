<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php 
use Core\Helpers;
use Core\Session;
use App\Models\Users;

 ?>

<?php $this->start('body'); ?>

<section id="products" class="container" style="margin-top: 4.5em;">

  <h1 class="category-header">Semua Produk</h1>

  <div class="products-list">

  	<?php foreach($this->products as $product): ?>

    <div class="product-card">
      <img class="product-card-img" src="<?= $product->url; ?>" alt="">
      <div class="product-card-detail">
        <span class="badge badge-dark product-card-category">
          <?= $product->category; ?>
        </span>
        <a href="<?= PROJECT_ROOT; ?>products/detail/<?= $product->id; ?>" class="product-card-detail-title"><?= $product->name; ?></a>
        <div class="product-card-detail-pricing">
          <span class="product-price">Rp. <?= $product->price; ?></span> 
          <?php if($product->rentable === 1): ?>
          	<span class="product-daily-cost">/ Hari</span>
          <?php endif; ?>
        </div>
        <button class="btn btn-lg btn-block btn-dark product-card-button">
          <i class="fas fa-cart-plus"></i>
        </button>
      </div>
    </div>

  	<?php endforeach; ?>


  </div>
</section>


<?php $this->end(); ?>

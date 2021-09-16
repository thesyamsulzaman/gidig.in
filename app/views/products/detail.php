<?php $this->setSiteTitle($this->product->name); ?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php

use Core\Helpers;


?>

<?php $this->start('body'); ?>
<section id="product-detail" class="container">
  <div class="navigator">
    <a href="<?= PROJECT_ROOT; ?>">
      <i class="fas fa-chevron-left"></i>
      Kembali
    </a>
  </div>

  <div class="product-detail">
    <div class="product-detail-images">
      <img class="product-detail-img" src="<?= PROJECT_ROOT . $this->images[0]->url; ?>" alt="">
      <div class="product-detail-sub-images">
        <?php foreach ($this->images as $image) : ?>
          <img class="product-detail-sub-image" alt="" src="<?= PROJECT_ROOT . $image->url; ?>">
        <?php endforeach; ?>
      </div>
    </div>

    <div class="product-detail-info">
      <h1 class="product-detail-title"><?= $this->product->name; ?></h1>
      <span class="product-detail-brand"><?= $this->product->getBrandName(); ?></span>

      <hr />

      <div class="product-detail-description">
        <span class="product-detail-description-header">
          Deskripsi Produk
        </span>
        <p>
          <?= $this->product->description ?>
        </p>
      </div>

      <hr />

      <div class="product-detail-cart-action">
        <p class="product-detail-price">Rp. <?= $this->product->price; ?></p>
        <a href="<?= PROJECT_ROOT; ?>cart/addToCart/<?= $this->product->id; ?>" class="btn btn-dark btn-block">
          <i class="fas fa-cart-plus"></i>
          Tambah ke Keranjang
        </a>
      </div>

    </div>

  </div>


</section>

<?php $this->end(); ?>
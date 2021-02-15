<?php $this->setSiteTitle($this->product->name); ?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php 

use Core\Helpers;


?>

<?php $this->start('body'); ?>
    <section id="products">
      <div class="container">

        <div class="navigator">
          <a href="<?= PROJECT_ROOT; ?>">
          <i class="fas fa-arrow-left"></i>
          	Kembali
        	</a>
        </div>

        <div class="product-detail">
          <div class="product-detail-images">
            <img class="product-detail-img" src="<?= PROJECT_ROOT . $this->images[0]->url; ?>" alt="">
            <div class="product-detail-sub-images">
              <?php foreach($this->images as $image): ?>
               <img class="product-detail-sub-image" alt="" src="<?= PROJECT_ROOT . $image->url; ?>">
              <?php endforeach; ?>
            </div>
          </div>

          <div class="product-detail-info">
            <h1 class="product-detail-title"><?= $this->product->name; ?></h1>
            <span><?= $this->product->getBrandName(); ?></span>
            <p class="product-detail-price">Rp. <?= $this->product->price; ?></p>


            <div class="product-detail-description">
              <span class="product-detail-description-header">
                Deskripsi Produk
              </span>
              <p>
                <?= $this->product->description ?>
              </p>
            </div>


            <div class="product-detail-cart-action">
              <div class="product-detail-cart-quantity">
                <button class="quantity-operator quantity-minus"> 
                  <img src="./icons/minus-square.svg" alt="">
                </button>
                <span>1</span>
                <button class="quantity-operator quantity-plus"> 
                  <img src="./icons/plus-square.svg" alt="">
                </button>
              </div>
              <button class="btn btn-lg btn-block btn-dark">
                <i class="fas fa-cart-plus"></i>
                Add to cart
              </button>

            </div>

          </div>

        </div>


      </div>
    </section>

<?php $this->end(); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

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
            <img class="product-detail-img" src="./images/images (1).jpeg" alt="">
            <div class="product-detail-sub-images">
              <img class="product-detail-sub-image sub-image-active" alt="" src="./images/images (1).jpeg">
              <img class="product-detail-sub-image" alt="" src="./images/images (3).jpeg">
              <img class="product-detail-sub-image" alt="" src="./images/images (4).jpeg">
            </div>
          </div>

          <div class="product-detail-info">
            <h1 class="product-detail-title">Mie Goreng Capcay</h1>
            <p class="product-detail-price">Rp 18.000</p>


            <div class="product-detail-description">
              <span class="product-detail-description-header">
                Deskripsi Produk
              </span>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
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
              <button class="btn btn-lg btn-block btn-dark">Add to cart</button>

            </div>

          </div>

        </div>


      </div>
    </section>

<?php $this->end(); ?>

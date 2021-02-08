<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php 

use Core\Helpers;
use Core\FormHelpers;

$categories = [
  'konsumsi' => 'Konsumsi',
  'dokumentasi' => 'Dokumentasi',
  'peralatan_camping' => 'Peralatan Camping',
];
  $rentableIsChecked = ($this->product->rentable === 1) ? "checked" : "" ;
  $featuredIsChecked = ($this->product->featured === 1) ? "checked" : "" ; 

  ?>

  <?php $this->start('body'); ?>

   <section id="edit-product" class="content-container">

    <div class="navigator">
      <a href="<?= PROJECT_ROOT; ?>product" class="">
	    <i class="fas fa-arrow-left"></i>
	    Kembali
  	</a>
  </div>
  
  <div class="content-form card shadow">
    <form action="<?= $this->formAction; ?>" method="POST" enctype="multipart/form-data">

      <div class="form-group">
         <?= FormHelpers::csrf_input(); ?>
      </div>
      
      <div class="form-group">
        <label for="name">Nama Produk</label>
        <input id="name" name="name" value="<?= $this->product->name; ?>" class="form-control" type="text">
      </div>

      <div class="form-group" style="display:flex; align-items: flex-start;">
        <div>
          <input name="rentable" <?= $rentableIsChecked; ?> type="checkbox" class="form-control"/>
          <label for="barang_sewa">Produk Sewaan</label>
        </div>
        <div style="margin-left: .9em;">
          <input name="featured" <?= $featuredIsChecked; ?> type="checkbox" class="form-control"/>
          <label for="featured">Produk Unggulan</label>
        </div>
      </div>


      <div class="form-group">
        <label for="kategori">Kategori Produk</label>
        <select id="kategori" name="category" class="form-control" selected="dokumentasi">
          <?php foreach ($categories as $field => $value) { ?>
            <option value="<?= $field; ?>" <?= ($field === $this->product->category) ? "selected" : "" ?> > <?= $value; ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group">
        <label for="harga">Harga Produk</label>
        <input id="harga" value="<?= $this->product->price; ?>"  name="price" class="form-control" type="number">
      </div>

      <div class="form-group">
        <label for="harga">Ongos Kirim</label>
        <input id="harga" value="<?= $this->product->shipping; ?>" name="shipping" class="form-control" type="number">
      </div>

      <div class="form-group">
        <label for="deskripsi"> Deskripsi Produk </label>
        <textarea name="description" id="deskripsi" class="form-control"><?= $this->product->description; ?></textarea>
      </div>

      <?php $this->partial('product','editImages') ?>

      <div class="form-group">
        <label>Gambar Produk</label>
        <input type="file" multiple="multiple" id="images[]" name="images[]" class="form-control">
      </div>


      <div class="form-group">
        <input class="btn btn-lg btn-block btn-dark" type="submit" value="Simpan"/>
      </div>


    </form>
  </div>

  <?= FormHelpers::parseErrorToFormFields($this->displayErrors); ?>
</section>

<?php $this->end(); ?>

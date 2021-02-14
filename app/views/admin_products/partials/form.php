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

<form action="<?= $this->formAction; ?>" method="POST" enctype="multipart/form-data">

  
  <div class="form-group">
    <label for="name">Nama Produk</label>
    <input id="name" name="name" value="<?= $this->product->name; ?>" class="form-control" type="text">
  </div>

    <div class="form-group">
      <label for="brand">Brand Produk</label>
      <select id="brand" name="brand" class="form-control">
        <?php foreach ($this->brands as $key => $value) { ?>
          <option value="<?= $key; ?>" <?= ($key === $this->product->brand_id) ? "selected" : "" ?> > <?= $value; ?></option>
        <?php } ?>
      </select>
    </div>

  <div class="form-group" style="display:flex; align-items: flex-start;">
    <div>
      <input name="rentable" <?= $rentableIsChecked; ?> type="checkbox" class="form-control"/>
      <label for="barang_sewa">Produk Sewaan</label>
    </div>
    <div style="margin-left: .9em;">
      <input name="featured" id="featured" <?= $featuredIsChecked; ?> type="checkbox" class="form-control"/>
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

  <div class="form-group drop-image" style="margin-bottom: .5em">
    <span class="drop-image__prompt">Drop atau Click untuk
      mengupload gambar produk</span>
    <input type="file" multiple name="images[]" class="form-control drop-image__holder"/>
  </div>
 

  <div class="form-group">
    <input class="btn btn-lg btn-block btn-dark" type="submit" value="Simpan"/>
  </div>
  
  <div class="form-group">
     <?= FormHelpers::csrf_input(); ?>
  </div>


</form>

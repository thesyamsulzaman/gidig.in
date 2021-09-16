<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php

use Core\Helpers;
use Core\Session;
use App\Models\Users;

?>

<?php $this->start('body'); ?>

<section id="list-product" class="content-container">

  <!--   <div class="alert show alert-success">
    <i class="fas fa-exclamation-circle"></i> 
    <span>Data Tersimpan</span>
    <div class="close-btn">
      <i class="fas fa-times"></i> 
    </div>
  </div>
 -->
  <div class="content-header">
    <p class="">Konsumsi</p>
    <a href="<?= PROJECT_ROOT; ?>adminproducts/add" class="add-product-button btn btn-dark"> + Tambah Produk</a>
  </div>
  <div class="content-table card shadow">
    <div class="table-header">
      <p class="">List Produk</p>
      <button class="btn btn-dark"> + Export</button>
    </div>
    <table>
      <tr>
        <th>Nama</th>
        <th>Harga</th>
        <th>Ongkir</th>
        <th>Barang Sewaan</th>
        <th>Produk Unggulan</th>
        <th>Aksi</th>
      </tr>
      <?php foreach ($this->products as $product) : ?>
        <tr data-id="<?= $product->id;  ?>">
          <td data-th="Nama"><?= $product->name; ?></td>
          <td data-th="Harga"><?= $product->price; ?></td>
          <td data-th="Ongkir"><?= $product->shipping; ?></td>
          <td data-th="Barang Sewaan">

            <?php if ($product->rentable === 1) : ?>
              <i class="fas fa-check-circle"></i>
            <?php else : ?>
              <i class="fas fa-times-circle"></i>
            <?php endif; ?>

          </td>
          <td data-id="<?= $product->id; ?>" data-th="Produk Unggulan">
            <?php if ($product->featured === 1) : ?>
              <i class="fas fa-check-circle"></i>
            <?php else : ?>
              <i class="fas fa-times-circle"></i>
            <?php endif; ?>
          </td>
          <td data-th="Aksi">
            <a href="" onclick="toggleFeatured('<?= $product->id; ?>'); return false;">
              <i data-id="<?= $product->id; ?>" class="<?= ($product->featured === 1) ? "fas fa-star" : "far fa-star"; ?>"></i>
            </a>
            <a href="<?= PROJECT_ROOT; ?>adminproducts/edit/<?= $product->id; ?>">
              <i class="fas fa-edit"></i>
            </a>
            <a href="#" onclick="deleteProduct('<?= $product->id; ?>'); return false;">
              <i class="fas fa-trash-alt"></i>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>


</section>


<script type="text/javascript" defer>
  function toggleFeatured(id) {
    fetch(`<?= PROJECT_ROOT; ?>adminproducts/toggleFeatured`, {
        method: "POST",
        mode: "same-origin",
        credentials: "same-origin",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          id
        })
      })
      .then(response => response.json())
      .then(data => {
        let starElem = document.querySelector(`i[data-id='${data.product_id}']`);
        let tdElem = document.querySelector(`td[data-id='${data.product_id}']`);

        let featured = (data.is_featured) ? "fas fa-star" : "far fa-star";
        let featuredStr = (data.is_featured) ? `<i class="fas fa-check-circle"></i>` : `<i class="fas fa-times-circle"></i>`;

        tdElem.innerHTML = featuredStr;
        starElem.className = featured;
      })


  }

  function deleteProduct(id) {
    if (window.confirm("Anda yakin ? ")) {

      $data = new FormData();
      $data.append("id", id);

      fetch(`<?= PROJECT_ROOT; ?>adminproducts/delete`, {
          method: "POST",
          mode: "same-origin",
          credentials: "same-origin",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            id
          })
        })
        .then(response => response.json())
        .then(data => {
          document.querySelector(`tr[data-id='${data.product_id}']`).remove();
        })
    }
  }
</script>

<?php $this->end(); ?>
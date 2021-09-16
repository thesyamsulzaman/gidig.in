<?php $this->start('head'); ?>
<?php $this->end(); ?>


<?php $this->start('body'); ?>

<section id="list-brands" class="content-container">
  <div class="content-header">
    <p class="">Brands</p>
    <a href="<?= PROJECT_ROOT; ?>adminbrands/add" class="add-product-button btn btn-dark"> + Tambah Data Brand</a>
  </div>
  <div class="content-table card shadow">
    <div class="table-header">
      <p class="">List Brands</p>
      <button class="btn btn-dark"> + Export</button>
    </div>
    <table>
      <tr>
        <th>Id</th>
        <th>Nama Brand</th>
        <th>Aksi</th>
      </tr>
      <?php foreach ($this->brands as $brand) : ?>
        <tr data-id="<?= $brand->id;  ?>">
          <td data-th="Nama"><?= $brand->id; ?></td>
          <td data-th="Nama"><?= $brand->name; ?></td>
          <td data-th="Aksi">
            <a href="<?= PROJECT_ROOT; ?>adminbrands/edit/<?= $brand->id; ?>">
              <i class="fas fa-edit"></i>
            </a>
            <a href="#" onclick="deleteProduct('<?= $brand->id; ?>'); return false;">
              <i class="fas fa-trash-alt"></i>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</section>


<script type="text/javascript" defer>
  function deleteProduct(id) {
    if (window.confirm("Anda yakin ? ")) {

      $data = new FormData();
      $data.append("id", id);

      fetch(`<?= PROJECT_ROOT; ?>adminbrands/deleteBrand`, {
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
          document.querySelector(`tr[data-id='${data.brand_id}']`).remove();
        })
    }
  }
</script>



<?php $this->end(); ?>
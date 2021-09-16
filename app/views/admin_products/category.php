<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php

use Core\Helpers;
use Core\Session;
use App\Models\Users;

?>

<?php $this->start('body'); ?>

<div class="content-container">
  <div class="content-header">
    <a href="./dashboard-produk_baru.html" class="">Konsumsi</a>
  </div>
  <div class="content-table card shadow">
    <table>
      <div class="table-header">
        <p class="">List Produk</p>
        <button class="btn btn-dark"> + Export</button>
      </div>
      <tr>
        <th>Id</th>
        <th>Gambar</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
      </tr>
      <tr>
        <td>USA</td>
        <td>Washington, D.C.</td>
        <td>309 million</td>
        <td>English</td>
      </tr>
      <tr>
        <td>Sweden</td>
        <td>Stockholm</td>
        <td>9 million</td>
        <td>Swedish</td>
      </tr>
    </table>
  </div>

  <?php Helpers::dnd($this->category); ?>

</div>




<?php $this->end(); ?>
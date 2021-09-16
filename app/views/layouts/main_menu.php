<?php

use Core\Router;
use Core\Helpers;

use App\Models\Users;

$currentPage = Helpers::currentPage();

?>

<header id="header">

  <div class="sidebar">

    <div class="categories-dropdown sidebar-item">
      <a href="#" class="dropdown-button">
        Categories
        <img class="dropdown-chevron" src="<?= STATIC_FILES; ?>build/icons/chevron-down.svg" height="15" alt="">
      </a>
      <div class="dropdown-content">
        <a href="#">Konsumsi</a>
        <a href="#">Dokumentasi</a>
        <a href="#">Peralatan Berkemah</a>
      </div>
    </div>

    <div class="user-action sidebar-item">
      <?php if (Users::currentUser()) : ?>
        <a href="<?= PROJECT_ROOT; ?>user/detail/<?= Users::currentUser()->id; ?>">Hi, <?= Users::currentUser()->first_name;  ?></a>
      <?php else : ?>
        <a href="<?= PROJECT_ROOT; ?>user/login" class="btn btn-lg btn-dark">Login</a>
        <a href="<?= PROJECT_ROOT; ?>user/register" class="btn btn-lg">Register</a>
      <?php endif; ?>
    </div>

  </div>

  <div class="container search-bar">
    <form action="" class="search-form">
      <input type="submit" class="search-button" value="">
      <input type="text" class="search-input" placeholder="Search for product">
      <img class="search-box-exit" src="<?= STATIC_FILES; ?>build/icons/x.svg" alt="" style="margin-right: .8em; cursor: pointer;">
    </form>
  </div>

  <div class="container navbar navbar-show">
    <button class="nav-menu-toggler">
      <img src="<?= STATIC_FILES; ?>build/icons/menu.svg" alt="">
    </button>

    <a href="<?= PROJECT_ROOT; ?>/" class="nav-home-link" style="flex:1;display:block;">
      <img style="" class="nav-logo" src="<?= STATIC_FILES; ?>build/icons/gidigin_icon.png" alt="">
    </a>

    <a class="search-toggler" href="#" style="margin-right: .5em; cursor: pointer;">
      <img width="22" src="<?= STATIC_FILES; ?>build/icons/search-alt.svg" alt="">
    </a>

    <a class="shopping-cart" href="<?= PROJECT_ROOT ?>cart/">
      <img src="<?= STATIC_FILES; ?>build/icons/shopping-cart.svg" alt="">
      <span>3</span>
    </a>
  </div>


</header>
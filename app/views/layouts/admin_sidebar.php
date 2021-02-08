<?php 


use Core\Helpers;
use Core\Router;

$currentPage = Helpers::currentPage();
$dashboard_menu = Router::get_menu("dashboard_menu_acl");

 ?>

   <aside id="dashboard-sidebar">
    <div class="dashboard-header">
      <img
        class="dashboard-logo"
        src="<?= STATIC_FILES; ?>build/icons/gidigin_icon-white.png"
        width="150"
        alt=""
      />
    </div>
    <ul class="sidebar-list">
      <?php 
      foreach ($dashboard_menu as $key => $value):
        $active = '';
      ?>

        <?php if (is_array($value)) : ?>

        <li class="sidebar-link accordion">
          <a href="#" class="accordion-header ">
            <strong><?= $key; ?></strong>
            <i class="fas fa-chevron-down accordion-header-chevron"></i>
          </a>
          <div class="accordion-body active">
            <ul class="accordion-list">
            <?php foreach($value as $k => $v): ?>
              <?php $active = ($v === $currentPage) ? 'active' : '' ; ?>
              <li class="accordion-link <?= $active; ?>">
                <a href="<?= $v; ?>"><?= $k; ?></a> 
              </li>
            <?php endforeach; ?>
            </ul>
          </div>
        </li>

        <?php else: ?>
          <?php $active = ($value === $currentPage) ? 'active' : '' ; ?>
          <li class="sidebar-link <?= $active; ?>">
            <i class="fas fa-home"></i>
            <a href="<?= $value; ?>">
              <?= $key; ?>
            </a>
          </li>

        <?php endif; ?>


      <?php endforeach; ?>
    </ul>
  </aside>


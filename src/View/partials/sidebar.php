<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar">
    <div class="logo">
        <img class="img-fluid" src="<?= BASE_URL ?>/assets/img/logo.png" alt="logo" style="width: 200px; height: auto;" />
    </div>
    <ul>
        <li><a href="<?= BASE_URL ?>/<?= ADMIN_PATH_PREFIX ?>/admin" class="<?= $current_page == 'admin.php' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="<?= BASE_URL ?>/<?= ADMIN_PATH_PREFIX ?>/admin_blog" class="<?= $current_page == 'admin_blog.php' ? 'active' : '' ?>">Blog</a></li>
        <li><a href="<?= BASE_URL ?>/<?= ADMIN_PATH_PREFIX ?>/admin_skema" class="<?= $current_page == 'admin_skema.php' ? 'active' : '' ?>">Skema</a></li>
        <li><a href="<?= BASE_URL ?>/<?= ADMIN_PATH_PREFIX ?>/admin_photo" class="<?= $current_page == 'admin_photo.php' ? 'active' : '' ?>">Photo</a></li>
        <?php if (isset($_SESSION['is_super_admin']) && $_SESSION['is_super_admin']): ?>
        <li><a href="<?= BASE_URL ?>/<?= ADMIN_PATH_PREFIX ?>/manage_admins" class="<?= $current_page == 'manage_admins.php' ? 'active' : '' ?>">Manage Admins</a></li>
        <?php endif; ?>
    </ul>
    <div class="sidebar-signout">
        <a href="<?= BASE_URL ?>/logout.php" class="btn btn-danger signout-btn-sidebar">Sign Out</a>
    </div>
</div>

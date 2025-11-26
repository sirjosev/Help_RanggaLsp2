<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar">
    <div class="logo">
        <img class="img-fluid" src="assets/img/logo.png" alt="logo" style="width: 200px; height: auto;" />
    </div>
    <ul>
        <li><a href="admin.php" class="<?= $current_page == 'admin.php' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="admin_blog.php" class="<?= $current_page == 'admin_blog.php' ? 'active' : '' ?>">Blog</a></li>
        <li><a href="admin_skema.php" class="<?= $current_page == 'admin_skema.php' ? 'active' : '' ?>">Skema</a></li>
        <li><a href="admin_photo.php" class="<?= $current_page == 'admin_photo.php' ? 'active' : '' ?>">Photo</a></li>
        <?php if (isset($_SESSION['is_super_admin']) && $_SESSION['is_super_admin']): ?>
        <li><a href="manage_admins.php" class="<?= $current_page == 'manage_admins.php' ? 'active' : '' ?>">Manage Admins</a></li>
        <?php endif; ?>
    </ul>
    <div class="sidebar-signout">
        <a href="logout.php" class="btn btn-danger signout-btn-sidebar">Sign Out</a>
    </div>
</div>

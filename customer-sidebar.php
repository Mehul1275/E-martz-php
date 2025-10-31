<div class="dashboard-sidebar">
    <div class="sidebar-header">
        <h4>My Account</h4>
        <p class="text-muted">Manage your E-martz account</p>
    </div>
    <nav class="sidebar-nav">
        <a href="dashboard.php" class="sidebar-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
            <i class="fa fa-tachometer"></i>
            <span><?php echo LANG_VALUE_89; ?></span>
        </a>
        <a href="customer-profile-update.php" class="sidebar-link <?php echo (basename($_SERVER['PHP_SELF']) == 'customer-profile-update.php') ? 'active' : ''; ?>">
            <i class="fa fa-user"></i>
            <span><?php echo LANG_VALUE_117; ?></span>
        </a>
        <a href="customer-billing-shipping-update.php" class="sidebar-link <?php echo (basename($_SERVER['PHP_SELF']) == 'customer-billing-shipping-update.php') ? 'active' : ''; ?>">
            <i class="fa fa-map-marker"></i>
            <span><?php echo LANG_VALUE_88; ?></span>
        </a>
        <a href="customer-password-update.php" class="sidebar-link <?php echo (basename($_SERVER['PHP_SELF']) == 'customer-password-update.php') ? 'active' : ''; ?>">
            <i class="fa fa-lock"></i>
            <span><?php echo LANG_VALUE_99; ?></span>
        </a>
        <a href="customer-order.php" class="sidebar-link <?php echo (basename($_SERVER['PHP_SELF']) == 'customer-order.php') ? 'active' : ''; ?>">
            <i class="fa fa-shopping-bag"></i>
            <span><?php echo LANG_VALUE_24; ?></span>
        </a>
        <a href="logout.php" class="sidebar-link logout-link">
            <i class="fa fa-sign-out"></i>
            <span><?php echo LANG_VALUE_14; ?></span>
        </a>
    </nav>
</div>
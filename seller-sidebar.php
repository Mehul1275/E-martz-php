<?php
$cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
?>
<aside class="main-sidebar seller-sidebar" id="sellerSidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="treeview <?php if($cur_page == 'seller-dashboard.php') {echo 'active';} ?>">
                <a href="seller-dashboard.php">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="<?php if($cur_page == 'seller-products.php') {echo 'active';} ?>">
                <a href="seller-products.php">
                    <i class="fa fa-cubes"></i> <span>Product Management</span>
                </a>
            </li>
            <li class="treeview <?php if($cur_page == 'seller-orders.php') {echo 'active';} ?>">
                <a href="seller-orders.php">
                    <i class="fa fa-shopping-cart"></i> <span>Order Management</span>
                </a>
            </li>
            <li class="treeview <?php if($cur_page == 'seller-payments.php') {echo 'active';} ?>">
                <a href="seller-payments.php">
                    <i class="fa fa-credit-card"></i> <span>View Payment</span>
                </a>
            </li>
            <li class="treeview <?php if($cur_page == 'seller-reviews.php') {echo 'active';} ?>">
                <a href="seller-reviews.php">
                    <i class="fa fa-star"></i> <span>Product Review</span>
                </a>
            </li>
            <li class="treeview <?php if($cur_page == 'seller-profile.php') {echo 'active';} ?>">
                <a href="seller-profile.php">
                    <i class="fa fa-user"></i> <span>Profile</span>
                </a>
            </li>
            <li class="treeview">
                <a href="seller-logout.php">
                    <i class="fa fa-sign-out"></i> <span>Logout</span>
                </a>
            </li>
        </ul>
    </section>
</aside> 
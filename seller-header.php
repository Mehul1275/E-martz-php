<header class="main-header">
    <a href="seller-dashboard.php" class="logo">
        <span class="logo-lg">E-martz Seller</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <span style="color:#fff;line-height:50px;padding-left:15px;font-size:18px;">Seller Panel</span>
        <div class="navbar-custom-menu" style="float:right;">
            <ul class="nav navbar-nav">
                <li style="line-height:50px; color:#fff; padding-right:20px; font-size:16px;">
                    <?php echo htmlspecialchars($_SESSION['seller']['fullname']); ?>
                </li>
            </ul>
        </div>
    </nav>
</header> 
<?php require_once('header.php'); ?>

<div class="page">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <div class="success-message" style="text-align: center; padding: 40px 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); margin: 40px 0;">
                    <?php if(isset($_SESSION['success_message'])): ?>
                        <h2 style="color: #28a745; margin-bottom: 20px;">✅ Order Confirmed!</h2>
                        <p style="font-size: 18px; margin-bottom: 30px;"><?php echo $_SESSION['success_message']; ?></p>
                    <?php else: ?>
                        <h2 style="color: #28a745; margin-bottom: 20px;">✅ Payment Successful!</h2>
                        <p style="font-size: 18px; margin-bottom: 30px;">Your order has been successfully placed and payment has been processed.</p>
                    <?php endif; ?>
                    
                    <div style="margin-top: 30px;">
                        <a href="dashboard.php" class="btn btn-success btn-lg" style="margin-right: 15px;">
                            <i class="fa fa-dashboard"></i> Go to Dashboard
                        </a>
                        <a href="customer-order.php" class="btn btn-info btn-lg" style="margin-right: 15px;">
                            <i class="fa fa-list"></i> View Orders
                        </a>
                        <a href="index.php" class="btn btn-primary btn-lg">
                            <i class="fa fa-home"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// Clear the success message after displaying
if(isset($_SESSION['success_message'])) {
    unset($_SESSION['success_message']);
}
require_once('footer.php'); 
?>
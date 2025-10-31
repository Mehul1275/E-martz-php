<?php require_once('header.php'); ?>
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);
$shipping_title = $row['shipping_title'];
$shipping_content = $row['shipping_content'];
$shipping_banner = $row['shipping_banner'];
$shipping_meta_title = $row['shipping_meta_title'];
$shipping_meta_keyword = $row['shipping_meta_keyword'];
$shipping_meta_description = $row['shipping_meta_description'];
?>
<title><?php echo htmlspecialchars($shipping_meta_title); ?></title>
<meta name="description" content="<?php echo htmlspecialchars($shipping_meta_description); ?>">
<meta name="keywords" content="<?php echo htmlspecialchars($shipping_meta_keyword); ?>">
<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <div class="page-header" style="margin-bottom: 30px;">
                    <h1><?php echo htmlspecialchars($shipping_title); ?></h1>
                    <p class="text-muted">Learn about our shipping policies, delivery times, and return procedures</p>
                </div>
                
                <div class="shipping-container" style="background:#fff; padding: 30px 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid var(--color-primary);">
                    <div class="shipping-content">
                        <?php echo $shipping_content; ?>
                    </div>
                    
                    <div class="shipping-highlights" style="margin-top: 40px; padding-top: 30px; border-top: 1px solid var(--color-neutral-200);">
                        <h3 style="margin-bottom: 25px; color: var(--color-neutral-900);"><i class="fa fa-star"></i> Shipping Highlights</h3>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="highlight-card" style="text-align: center; padding: 25px 15px; background: #ecfdf5; border-radius: 12px; border: 1px solid #a7f3d0; margin-bottom: 20px;">
                                    <i class="fa fa-rocket" style="font-size: 32px; color: #059669; margin-bottom: 15px;"></i>
                                    <h5 style="color: #065f46; margin-bottom: 8px;">Fast Delivery</h5>
                                    <p style="font-size: 13px; color: #065f46; margin: 0;">1-2 business days processing</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="highlight-card" style="text-align: center; padding: 25px 15px; background: #eff6ff; border-radius: 12px; border: 1px solid #bfdbfe; margin-bottom: 20px;">
                                    <i class="fa fa-shield" style="font-size: 32px; color: #1e40af; margin-bottom: 15px;"></i>
                                    <h5 style="color: #1e3a8a; margin-bottom: 8px;">Secure Packaging</h5>
                                    <p style="font-size: 13px; color: #1e3a8a; margin: 0;">Safe & secure delivery</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="highlight-card" style="text-align: center; padding: 25px 15px; background: #fef3c7; border-radius: 12px; border: 1px solid #fde68a; margin-bottom: 20px;">
                                    <i class="fa fa-map-marker" style="font-size: 32px; color: #d97706; margin-bottom: 15px;"></i>
                                    <h5 style="color: #92400e; margin-bottom: 8px;">Order Tracking</h5>
                                    <p style="font-size: 13px; color: #92400e; margin: 0;">Real-time tracking updates</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="highlight-card" style="text-align: center; padding: 25px 15px; background: #fef2f2; border-radius: 12px; border: 1px solid #fecaca; margin-bottom: 20px;">
                                    <i class="fa fa-undo" style="font-size: 32px; color: #dc2626; margin-bottom: 15px;"></i>
                                    <h5 style="color: #991b1b; margin-bottom: 8px;">Easy Returns</h5>
                                    <p style="font-size: 13px; color: #991b1b; margin: 0;">7-day return policy</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="shipping-sections" style="margin-top: 40px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="section-card" style="background: #fff; border: 1px solid var(--color-neutral-200); border-radius: 12px; padding: 25px; margin-bottom: 20px; height: 100%;">
                                    <h4 style="color: var(--color-primary); margin-bottom: 20px;"><i class="fa fa-truck"></i> Shipping Information</h4>
                                    <div class="info-list">
                                        <div class="info-item" style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                                            <i class="fa fa-check-circle" style="color: var(--color-success); margin-right: 12px; margin-top: 3px; font-size: 16px;"></i>
                                            <div>
                                                <strong>Processing Time:</strong><br>
                                                <span style="color: var(--color-neutral-600); font-size: 14px;">Orders processed within 1-2 business days</span>
                                            </div>
                                        </div>
                                        <div class="info-item" style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                                            <i class="fa fa-check-circle" style="color: var(--color-success); margin-right: 12px; margin-top: 3px; font-size: 16px;"></i>
                                            <div>
                                                <strong>Standard Delivery:</strong><br>
                                                <span style="color: var(--color-neutral-600); font-size: 14px;">3-7 business days depending on location</span>
                                            </div>
                                        </div>
                                        <div class="info-item" style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                                            <i class="fa fa-check-circle" style="color: var(--color-success); margin-right: 12px; margin-top: 3px; font-size: 16px;"></i>
                                            <div>
                                                <strong>Tracking:</strong><br>
                                                <span style="color: var(--color-neutral-600); font-size: 14px;">Email notifications with tracking number</span>
                                            </div>
                                        </div>
                                        <div class="info-item" style="display: flex; align-items: flex-start;">
                                            <i class="fa fa-check-circle" style="color: var(--color-success); margin-right: 12px; margin-top: 3px; font-size: 16px;"></i>
                                            <div>
                                                <strong>Shipping Areas:</strong><br>
                                                <span style="color: var(--color-neutral-600); font-size: 14px;">Currently shipping within India only</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="section-card" style="background: #fff; border: 1px solid var(--color-neutral-200); border-radius: 12px; padding: 25px; margin-bottom: 20px; height: 100%;">
                                    <h4 style="color: var(--color-primary); margin-bottom: 20px;"><i class="fa fa-refresh"></i> Return Policy</h4>
                                    <div class="info-list">
                                        <div class="info-item" style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                                            <i class="fa fa-clock-o" style="color: var(--color-warning); margin-right: 12px; margin-top: 3px; font-size: 16px;"></i>
                                            <div>
                                                <strong>Return Window:</strong><br>
                                                <span style="color: var(--color-neutral-600); font-size: 14px;">7 days from delivery date</span>
                                            </div>
                                        </div>
                                        <div class="info-item" style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                                            <i class="fa fa-tag" style="color: var(--color-warning); margin-right: 12px; margin-top: 3px; font-size: 16px;"></i>
                                            <div>
                                                <strong>Condition:</strong><br>
                                                <span style="color: var(--color-neutral-600); font-size: 14px;">Items must be unused with original tags</span>
                                            </div>
                                        </div>
                                        <div class="info-item" style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                                            <i class="fa fa-money" style="color: var(--color-warning); margin-right: 12px; margin-top: 3px; font-size: 16px;"></i>
                                            <div>
                                                <strong>Refund Process:</strong><br>
                                                <span style="color: var(--color-neutral-600); font-size: 14px;">Processed within 5-7 business days</span>
                                            </div>
                                        </div>
                                        <div class="info-item" style="display: flex; align-items: flex-start;">
                                            <i class="fa fa-phone" style="color: var(--color-warning); margin-right: 12px; margin-top: 3px; font-size: 16px;"></i>
                                            <div>
                                                <strong>Return Request:</strong><br>
                                                <span style="color: var(--color-neutral-600); font-size: 14px;">Contact support to initiate return</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="shipping-footer" style="margin-top: 30px; padding: 25px; background: #f8fafc; border-radius: 12px; text-align: center;">
                        <h4 style="margin-bottom: 15px; color: var(--color-neutral-900);"><i class="fa fa-question-circle"></i> Need Help with Shipping?</h4>
                        <p style="color: var(--color-neutral-600); margin-bottom: 20px;">
                            Have questions about your order or need to initiate a return? Our support team is here to help.
                        </p>
                        <div class="action-buttons">
                            <a href="track-order.php" class="btn btn-primary" style="margin-right: 15px;">
                                <i class="fa fa-search"></i> Track Your Order
                            </a>
                            <a href="contact.php" class="btn btn-outline">
                                <i class="fa fa-envelope"></i> Contact Support
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>

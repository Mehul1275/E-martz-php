<?php require_once('header.php'); ?>
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);
$seller_tnc_title = $row['seller_tnc_title'];
$seller_tnc_content = $row['seller_tnc_content'];
$seller_tnc_banner = $row['seller_tnc_banner'];
$seller_tnc_meta_title = $row['seller_tnc_meta_title'];
$seller_tnc_meta_keyword = $row['seller_tnc_meta_keyword'];
$seller_tnc_meta_description = $row['seller_tnc_meta_description'];
?>
<title>E-martz | Seller Terms & Conditions </title>
<meta name="description" content="<?php echo htmlspecialchars($seller_tnc_meta_description); ?>">
<meta name="keywords" content="<?php echo htmlspecialchars($seller_tnc_meta_keyword); ?>">
<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <div class="page-header" style="margin-bottom: 30px;">
                    <h1><?php echo htmlspecialchars($seller_tnc_title); ?></h1>
                    <p class="text-muted">Terms and conditions for sellers on our marketplace platform</p>
                </div>
                
                <div class="seller-tnc-container" style="background:#fff; padding: 30px 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid var(--color-primary);">
                    <div class="seller-intro" style="text-align: center; margin-bottom: 40px; padding: 30px; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-radius: 12px;">
                        <i class="fa fa-store" style="font-size: 48px; color: var(--color-primary); margin-bottom: 15px;"></i>
                        <h2 style="color: var(--color-neutral-900); margin-bottom: 10px;">Seller Agreement</h2>
                        <p style="color: var(--color-neutral-600); margin: 0; font-size: 16px;">Please read and understand these terms before joining our marketplace as a seller</p>
                    </div>

                    <div class="seller-tnc-content">
                        <?php echo $seller_tnc_content; ?>
                    </div>
                    
                    <div class="seller-highlights" style="margin-top: 40px; padding-top: 30px; border-top: 1px solid var(--color-neutral-200);">
                        <h3 style="margin-bottom: 25px; color: var(--color-neutral-900);"><i class="fa fa-handshake-o"></i> Key Seller Benefits</h3>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="benefit-card" style="text-align: center; padding: 25px 15px; background: #ecfdf5; border-radius: 12px; border: 1px solid #a7f3d0; margin-bottom: 20px;">
                                    <i class="fa fa-users" style="font-size: 32px; color: #059669; margin-bottom: 15px;"></i>
                                    <h5 style="color: #065f46; margin-bottom: 8px;">Large Customer Base</h5>
                                    <p style="font-size: 13px; color: #065f46; margin: 0;">Access to thousands of active customers</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="benefit-card" style="text-align: center; padding: 25px 15px; background: #eff6ff; border-radius: 12px; border: 1px solid #bfdbfe; margin-bottom: 20px;">
                                    <i class="fa fa-chart-line" style="font-size: 32px; color: #1e40af; margin-bottom: 15px;"></i>
                                    <h5 style="color: #1e3a8a; margin-bottom: 8px;">Sales Analytics</h5>
                                    <p style="font-size: 13px; color: #1e3a8a; margin: 0;">Detailed insights and reporting tools</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="benefit-card" style="text-align: center; padding: 25px 15px; background: #fef3c7; border-radius: 12px; border: 1px solid #fde68a; margin-bottom: 20px;">
                                    <i class="fa fa-credit-card" style="font-size: 32px; color: #d97706; margin-bottom: 15px;"></i>
                                    <h5 style="color: #92400e; margin-bottom: 8px;">Secure Payments</h5>
                                    <p style="font-size: 13px; color: #92400e; margin: 0;">Fast and secure payment processing</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="benefit-card" style="text-align: center; padding: 25px 15px; background: #fef2f2; border-radius: 12px; border: 1px solid #fecaca; margin-bottom: 20px;">
                                    <i class="fa fa-headphones" style="font-size: 32px; color: #dc2626; margin-bottom: 15px;"></i>
                                    <h5 style="color: #991b1b; margin-bottom: 8px;">24/7 Support</h5>
                                    <p style="font-size: 13px; color: #991b1b; margin: 0;">Dedicated seller support team</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="seller-requirements" style="margin-top: 40px;">
                        <h3 style="margin-bottom: 25px; color: var(--color-neutral-900);"><i class="fa fa-check-square"></i> Seller Requirements</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="requirement-card" style="background: #fff; border: 1px solid var(--color-neutral-200); border-radius: 12px; padding: 25px; margin-bottom: 20px; height: 100%;">
                                    <h4 style="color: var(--color-primary); margin-bottom: 20px;"><i class="fa fa-user-check"></i> Eligibility Criteria</h4>
                                    <div class="requirement-list">
                                        <div class="requirement-item" style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                                            <i class="fa fa-check-circle" style="color: var(--color-success); margin-right: 12px; margin-top: 3px; font-size: 16px;"></i>
                                            <div>
                                                <strong>Business Registration:</strong><br>
                                                <span style="color: var(--color-neutral-600); font-size: 14px;">Valid business license or registration documents</span>
                                            </div>
                                        </div>
                                        <div class="requirement-item" style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                                            <i class="fa fa-check-circle" style="color: var(--color-success); margin-right: 12px; margin-top: 3px; font-size: 16px;"></i>
                                            <div>
                                                <strong>Tax Compliance:</strong><br>
                                                <span style="color: var(--color-neutral-600); font-size: 14px;">Valid GST registration and tax documents</span>
                                            </div>
                                        </div>
                                        <div class="requirement-item" style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                                            <i class="fa fa-check-circle" style="color: var(--color-success); margin-right: 12px; margin-top: 3px; font-size: 16px;"></i>
                                            <div>
                                                <strong>Bank Account:</strong><br>
                                                <span style="color: var(--color-neutral-600); font-size: 14px;">Business bank account for payments</span>
                                            </div>
                                        </div>
                                        <div class="requirement-item" style="display: flex; align-items: flex-start;">
                                            <i class="fa fa-check-circle" style="color: var(--color-success); margin-right: 12px; margin-top: 3px; font-size: 16px;"></i>
                                            <div>
                                                <strong>Product Quality:</strong><br>
                                                <span style="color: var(--color-neutral-600); font-size: 14px;">Commitment to authentic, quality products</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="responsibility-card" style="background: #fff; border: 1px solid var(--color-neutral-200); border-radius: 12px; padding: 25px; margin-bottom: 20px; height: 100%;">
                                    <h4 style="color: var(--color-primary); margin-bottom: 20px;"><i class="fa fa-tasks"></i> Seller Responsibilities</h4>
                                    <div class="responsibility-list">
                                        <div class="responsibility-item" style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                                            <i class="fa fa-exclamation-circle" style="color: var(--color-warning); margin-right: 12px; margin-top: 3px; font-size: 16px;"></i>
                                            <div>
                                                <strong>Order Fulfillment:</strong><br>
                                                <span style="color: var(--color-neutral-600); font-size: 14px;">Process orders within 24-48 hours</span>
                                            </div>
                                        </div>
                                        <div class="responsibility-item" style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                                            <i class="fa fa-exclamation-circle" style="color: var(--color-warning); margin-right: 12px; margin-top: 3px; font-size: 16px;"></i>
                                            <div>
                                                <strong>Product Information:</strong><br>
                                                <span style="color: var(--color-neutral-600); font-size: 14px;">Accurate descriptions and images</span>
                                            </div>
                                        </div>
                                        <div class="responsibility-item" style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                                            <i class="fa fa-exclamation-circle" style="color: var(--color-warning); margin-right: 12px; margin-top: 3px; font-size: 16px;"></i>
                                            <div>
                                                <strong>Customer Service:</strong><br>
                                                <span style="color: var(--color-neutral-600); font-size: 14px;">Respond to customer queries promptly</span>
                                            </div>
                                        </div>
                                        <div class="responsibility-item" style="display: flex; align-items: flex-start;">
                                            <i class="fa fa-exclamation-circle" style="color: var(--color-warning); margin-right: 12px; margin-top: 3px; font-size: 16px;"></i>
                                            <div>
                                                <strong>Return Policy:</strong><br>
                                                <span style="color: var(--color-neutral-600); font-size: 14px;">Honor return and refund policies</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="seller-footer" style="margin-top: 40px; padding-top: 30px; border-top: 1px solid var(--color-neutral-200);">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="agreement-notice" style="background: #ecfdf5; padding: 20px; border-radius: 8px; border: 1px solid #a7f3d0;">
                                    <h4 style="color: #065f46; margin-bottom: 10px;"><i class="fa fa-info-circle"></i> Agreement Acceptance</h4>
                                    <p style="color: #065f46; margin: 0; font-size: 14px;">
                                        By registering as a seller on our platform, you acknowledge that you have read, understood, and agree to be bound by these seller terms and conditions.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="seller-actions" style="background: #fff; border: 1px solid var(--color-neutral-200); border-radius: 8px; padding: 20px;">
                                    <h4><i class="fa fa-rocket"></i> Ready to Sell?</h4>
                                    <p style="color: var(--color-neutral-600); font-size: 14px; margin-bottom: 15px;">
                                        Join our marketplace today
                                    </p>
                                    <a href="seller-registration.php" class="btn btn-primary btn-sm" style="margin-bottom: 10px; width: 100%;">
                                        <i class="fa fa-user-plus"></i> Register as Seller
                                    </a>
                                    <a href="contact.php" class="btn btn-outline btn-sm" style="width: 100%;">
                                        <i class="fa fa-envelope"></i> Contact Us
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>

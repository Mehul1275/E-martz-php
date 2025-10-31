<?php require_once('header.php'); ?>
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);
$privacy_title = $row['privacy_title'];
$privacy_content = $row['privacy_content'];
$privacy_banner = $row['privacy_banner'];
$privacy_meta_title = $row['privacy_meta_title'];
$privacy_meta_keyword = $row['privacy_meta_keyword'];
$privacy_meta_description = $row['privacy_meta_description'];
?>
<title><?php echo htmlspecialchars($privacy_meta_title); ?></title>
<meta name="description" content="<?php echo htmlspecialchars($privacy_meta_description); ?>">
<meta name="keywords" content="<?php echo htmlspecialchars($privacy_meta_keyword); ?>">
<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <div class="page-header" style="margin-bottom: 30px;">
                    <h1><?php echo htmlspecialchars($privacy_title); ?></h1>
                    <p class="text-muted">We value your privacy and are committed to protecting your personal information</p>
                </div>
                
                <div class="privacy-container" style="background:#fff; padding: 30px 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid var(--color-primary);">
                    <div class="privacy-content">
                        <?php echo $privacy_content; ?>
                    </div>
                    
                    <div class="privacy-footer" style="margin-top: 40px; padding-top: 30px; border-top: 1px solid var(--color-neutral-200);">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="security-notice" style="background: #eff6ff; padding: 20px; border-radius: 8px; border: 1px solid #bfdbfe;">
                                    <h4 style="color: #1e40af; margin-bottom: 10px;"><i class="fa fa-shield"></i> Data Security</h4>
                                    <p style="color: #1e40af; margin: 0; font-size: 14px;">
                                        We use industry-standard security measures to protect your personal information and ensure data privacy.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="contact-section" style="background: #fff; border: 1px solid var(--color-neutral-200); border-radius: 8px; padding: 20px;">
                                    <h4><i class="fa fa-envelope"></i> Privacy Questions?</h4>
                                    <p style="color: var(--color-neutral-600); font-size: 14px; margin-bottom: 15px;">
                                        Contact us about privacy concerns or data requests
                                    </p>
                                    <a href="contact.php" class="btn btn-primary btn-sm">
                                        <i class="fa fa-phone"></i> Contact Support
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="privacy-highlights" style="margin-top: 30px;">
                            <h4 style="margin-bottom: 20px; color: var(--color-neutral-900);"><i class="fa fa-key"></i> Privacy Highlights</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="highlight-card" style="text-align: center; padding: 20px; background: var(--color-neutral-50); border-radius: 8px; margin-bottom: 15px;">
                                        <i class="fa fa-lock" style="font-size: 24px; color: var(--color-primary); margin-bottom: 10px;"></i>
                                        <h5>Secure Data</h5>
                                        <p style="font-size: 13px; color: var(--color-neutral-600); margin: 0;">Your data is encrypted and stored securely</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="highlight-card" style="text-align: center; padding: 20px; background: var(--color-neutral-50); border-radius: 8px; margin-bottom: 15px;">
                                        <i class="fa fa-ban" style="font-size: 24px; color: var(--color-primary); margin-bottom: 10px;"></i>
                                        <h5>No Spam</h5>
                                        <p style="font-size: 13px; color: var(--color-neutral-600); margin: 0;">We never share your email with third parties</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="highlight-card" style="text-align: center; padding: 20px; background: var(--color-neutral-50); border-radius: 8px; margin-bottom: 15px;">
                                        <i class="fa fa-user-shield" style="font-size: 24px; color: var(--color-primary); margin-bottom: 10px;"></i>
                                        <h5>Your Control</h5>
                                        <p style="font-size: 13px; color: var(--color-neutral-600); margin: 0;">Manage your privacy settings anytime</p>
                                    </div>
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

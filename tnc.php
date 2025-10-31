<?php require_once('header.php'); ?>
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);
$tnc_title = $row['tnc_title'];
$tnc_content = $row['tnc_content'];
$tnc_banner = $row['tnc_banner'];
$tnc_meta_title = $row['tnc_meta_title'];
$tnc_meta_keyword = $row['tnc_meta_keyword'];
$tnc_meta_description = $row['tnc_meta_description'];
?>
<title><?php echo htmlspecialchars($tnc_meta_title); ?></title>
<meta name="description" content="<?php echo htmlspecialchars($tnc_meta_description); ?>">
<meta name="keywords" content="<?php echo htmlspecialchars($tnc_meta_keyword); ?>">
<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <div class="page-header" style="margin-bottom: 30px;">
                    <h1><?php echo htmlspecialchars($tnc_title); ?></h1>
                    <p class="text-muted">Please read these terms and conditions carefully before using our services</p>
                </div>
                
                <div class="tnc-container" style="background:#fff; padding: 30px 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid var(--color-primary);">
                    <div class="tnc-content">
                        <?php echo $tnc_content; ?>
                    </div>
                    
                    <div class="tnc-footer" style="margin-top: 40px; padding-top: 30px; border-top: 1px solid var(--color-neutral-200);">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="legal-notice" style="background: #ecfdf5; padding: 20px; border-radius: 8px; border: 1px solid #a7f3d0;">
                                    <h4 style="color: #065f46; margin-bottom: 10px;"><i class="fa fa-info-circle"></i> Important Notice</h4>
                                    <p style="color: #065f46; margin: 0; font-size: 14px;">
                                        By using our website and services, you acknowledge that you have read, understood, and agree to be bound by these terms and conditions.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="help-section" style="background: #fff; border: 1px solid var(--color-neutral-200); border-radius: 8px; padding: 20px;">
                                    <h4><i class="fa fa-question-circle"></i> Need Help?</h4>
                                    <p style="color: var(--color-neutral-600); font-size: 14px; margin-bottom: 15px;">
                                        Have questions about our terms?
                                    </p>
                                    <a href="contact.php" class="btn btn-primary btn-sm">
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

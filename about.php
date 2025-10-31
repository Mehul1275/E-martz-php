<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
   $about_title = $row['about_title'];
    $about_content = $row['about_content'];
    $about_banner = $row['about_banner'];
}
?>

<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <div class="page-header" style="margin-bottom: 30px;">
                    <h1><?php echo htmlspecialchars($about_title); ?></h1>
                    <p class="text-muted">Learn more about our company, mission, and values</p>
                </div>
                
                <div class="about-container" style="background:#fff; padding: 30px 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid var(--color-primary);">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="about-content">
                                <?php echo $about_content; ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="about-sidebar">
                                <div class="sidebar-section" style="background: #f8fafc; padding: 25px; border-radius: 8px; border: 1px solid #e5e7eb;">
                                    <h4 style="color: var(--color-primary); margin-bottom: 20px; text-align: center;">
                                        <i class="fa fa-star"></i> Why Choose Us
                                    </h4>
                                    
                                    <div class="feature-list">
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px; padding: 15px; background: #fff; border-radius: 6px; border: 1px solid #e5e7eb;">
                                            <div class="feature-icon" style="width: 40px; height: 40px; background: var(--color-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                                                <i class="fa fa-shield" style="color: white; font-size: 16px;"></i>
                                            </div>
                                            <div class="feature-content">
                                                <div class="feature-title" style="font-weight: 600; color: var(--color-neutral-900); margin-bottom: 3px;">Secure Shopping</div>
                                                <div class="feature-desc" style="color: var(--color-neutral-600); font-size: 13px;">SSL encryption and safe payment processing</div>
                                            </div>
                                        </div>
                                        
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px; padding: 15px; background: #fff; border-radius: 6px; border: 1px solid #e5e7eb;">
                                            <div class="feature-icon" style="width: 40px; height: 40px; background: var(--color-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                                                <i class="fa fa-truck" style="color: white; font-size: 16px;"></i>
                                            </div>
                                            <div class="feature-content">
                                                <div class="feature-title" style="font-weight: 600; color: var(--color-neutral-900); margin-bottom: 3px;">Fast Shipping</div>
                                                <div class="feature-desc" style="color: var(--color-neutral-600); font-size: 13px;">Quick and reliable delivery nationwide</div>
                                            </div>
                                        </div>
                                        
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px; padding: 15px; background: #fff; border-radius: 6px; border: 1px solid #e5e7eb;">
                                            <div class="feature-icon" style="width: 40px; height: 40px; background: var(--color-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                                                <i class="fa fa-thumbs-up" style="color: white; font-size: 16px;"></i>
                                            </div>
                                            <div class="feature-content">
                                                <div class="feature-title" style="font-weight: 600; color: var(--color-neutral-900); margin-bottom: 3px;">Quality Products</div>
                                                <div class="feature-desc" style="color: var(--color-neutral-600); font-size: 13px;">Verified sellers and authentic products</div>
                                            </div>
                                        </div>
                                        
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px; padding: 15px; background: #fff; border-radius: 6px; border: 1px solid #e5e7eb;">
                                            <div class="feature-icon" style="width: 40px; height: 40px; background: var(--color-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                                                <i class="fa fa-headphones" style="color: white; font-size: 16px;"></i>
                                            </div>
                                            <div class="feature-content">
                                                <div class="feature-title" style="font-weight: 600; color: var(--color-neutral-900); margin-bottom: 3px;">24/7 Support</div>
                                                <div class="feature-desc" style="color: var(--color-neutral-600); font-size: 13px;">Customer service whenever you need it</div>
                                            </div>
                                        </div>
                                        
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 0; padding: 15px; background: #fff; border-radius: 6px; border: 1px solid #e5e7eb;">
                                            <div class="feature-icon" style="width: 40px; height: 40px; background: var(--color-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                                                <i class="fa fa-undo" style="color: white; font-size: 16px;"></i>
                                            </div>
                                            <div class="feature-content">
                                                <div class="feature-title" style="font-weight: 600; color: var(--color-neutral-900); margin-bottom: 3px;">Easy Returns</div>
                                                <div class="feature-desc" style="color: var(--color-neutral-600); font-size: 13px;">Hassle-free return and refund policy</div>
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
    </div>
</div>

<?php require_once('footer.php'); ?>
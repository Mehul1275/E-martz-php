<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $contact_email = $row['contact_email'];
}
?>
<title> E-martz | Help & Support </title>
<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <div class="page-header" style="margin-bottom: 30px;">
                    <h1>Help & Support</h1>
                    <p class="text-muted">Find answers to common questions or get in touch with our support team</p>
                </div>
                
                <div class="help-container" style="background:#fff; padding: 30px 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <div class="help-intro" style="text-align: center; margin-bottom: 40px; padding: 30px; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-radius: 12px;">
                        <i class="fa fa-life-ring" style="font-size: 48px; color: var(--color-primary); margin-bottom: 15px;"></i>
                        <h2 style="color: var(--color-neutral-900); margin-bottom: 10px;">How can we help you?</h2>
                        <p style="color: var(--color-neutral-600); margin: 0; font-size: 16px;">Browse our frequently asked questions or contact our support team for assistance</p>
                    </div>

                    <div class="faq-section">
                        <h3 style="margin-bottom: 25px; color: var(--color-neutral-900);"><i class="fa fa-question-circle"></i> Frequently Asked Questions</h3>
                        
                        <div class="faq-accordion" id="helpAccordion">
                            <div class="faq-item" style="margin-bottom: 15px; border: 1px solid var(--color-neutral-200); border-radius: 8px; overflow: hidden;">
                                <div class="faq-question" style="background: var(--color-neutral-50); padding: 20px; cursor: pointer; transition: background 0.2s;" data-toggle="collapse" data-target="#faq1">
                                    <h5 style="margin: 0; color: var(--color-neutral-900); display: flex; justify-content: space-between; align-items: center;">
                                        <span><i class="fa fa-shopping-cart" style="margin-right: 10px; color: var(--color-primary);"></i>How do I place an order?</span>
                                        <i class="fa fa-chevron-down" style="color: var(--color-neutral-500);"></i>
                                    </h5>
                                </div>
                                <div id="faq1" class="faq-answer collapse" style="padding: 20px; background: #fff;">
                                    <p style="margin: 0; color: var(--color-neutral-700); line-height: 1.6;">
                                        Browse products, add to cart, and proceed to checkout. Follow the on-screen instructions to complete your purchase. You can pay using various secure payment methods.
                                    </p>
                                </div>
                            </div>

                            <div class="faq-item" style="margin-bottom: 15px; border: 1px solid var(--color-neutral-200); border-radius: 8px; overflow: hidden;">
                                <div class="faq-question" style="background: var(--color-neutral-50); padding: 20px; cursor: pointer; transition: background 0.2s;" data-toggle="collapse" data-target="#faq2">
                                    <h5 style="margin: 0; color: var(--color-neutral-900); display: flex; justify-content: space-between; align-items: center;">
                                        <span><i class="fa fa-credit-card" style="margin-right: 10px; color: var(--color-primary);"></i>What payment methods are accepted?</span>
                                        <i class="fa fa-chevron-down" style="color: var(--color-neutral-500);"></i>
                                    </h5>
                                </div>
                                <div id="faq2" class="faq-answer collapse" style="padding: 20px; background: #fff;">
                                    <p style="margin: 0; color: var(--color-neutral-700); line-height: 1.6;">
                                        We accept credit/debit cards, PayPal, net banking, UPI, and cash on delivery. All transactions are secured with SSL encryption for your safety.
                                    </p>
                                </div>
                            </div>

                            <div class="faq-item" style="margin-bottom: 15px; border: 1px solid var(--color-neutral-200); border-radius: 8px; overflow: hidden;">
                                <div class="faq-question" style="background: var(--color-neutral-50); padding: 20px; cursor: pointer; transition: background 0.2s;" data-toggle="collapse" data-target="#faq3">
                                    <h5 style="margin: 0; color: var(--color-neutral-900); display: flex; justify-content: space-between; align-items: center;">
                                        <span><i class="fa fa-truck" style="margin-right: 10px; color: var(--color-primary);"></i>How can I track my order?</span>
                                        <i class="fa fa-chevron-down" style="color: var(--color-neutral-500);"></i>
                                    </h5>
                                </div>
                                <div id="faq3" class="faq-answer collapse" style="padding: 20px; background: #fff;">
                                    <p style="margin: 0; color: var(--color-neutral-700); line-height: 1.6;">
                                        Log in to your account and go to 'Your Orders' to view order status and tracking information. You can also use our <a href="track-order.php">order tracking page</a> with your tracking ID.
                                    </p>
                                </div>
                            </div>

                            <div class="faq-item" style="margin-bottom: 15px; border: 1px solid var(--color-neutral-200); border-radius: 8px; overflow: hidden;">
                                <div class="faq-question" style="background: var(--color-neutral-50); padding: 20px; cursor: pointer; transition: background 0.2s;" data-toggle="collapse" data-target="#faq4">
                                    <h5 style="margin: 0; color: var(--color-neutral-900); display: flex; justify-content: space-between; align-items: center;">
                                        <span><i class="fa fa-undo" style="margin-right: 10px; color: var(--color-primary);"></i>What is your return policy?</span>
                                        <i class="fa fa-chevron-down" style="color: var(--color-neutral-500);"></i>
                                    </h5>
                                </div>
                                <div id="faq4" class="faq-answer collapse" style="padding: 20px; background: #fff;">
                                    <p style="margin: 0; color: var(--color-neutral-700); line-height: 1.6;">
                                        Returns are accepted within 7 days of delivery. Please see our <a href="shipping-returns.php">Returns & Refunds section</a> for complete details and conditions.
                                    </p>
                                </div>
                            </div>

                            <div class="faq-item" style="margin-bottom: 15px; border: 1px solid var(--color-neutral-200); border-radius: 8px; overflow: hidden;">
                                <div class="faq-question" style="background: var(--color-neutral-50); padding: 20px; cursor: pointer; transition: background 0.2s;" data-toggle="collapse" data-target="#faq5">
                                    <h5 style="margin: 0; color: var(--color-neutral-900); display: flex; justify-content: space-between; align-items: center;">
                                        <span><i class="fa fa-headphones" style="margin-right: 10px; color: var(--color-primary);"></i>How do I contact customer support?</span>
                                        <i class="fa fa-chevron-down" style="color: var(--color-neutral-500);"></i>
                                    </h5>
                                </div>
                                <div id="faq5" class="faq-answer collapse" style="padding: 20px; background: #fff;">
                                    <p style="margin: 0; color: var(--color-neutral-700); line-height: 1.6;">
                                        Email us at <a href="mailto:<?php echo $contact_email; ?>"><?php echo $contact_email; ?></a> or use our <a href="contact.php">Contact Form</a>. We typically respond within 24 hours.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="help-footer" style="margin-top: 40px; padding-top: 30px; border-top: 1px solid var(--color-neutral-200);">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="support-card" style="background: #ecfdf5; padding: 25px; border-radius: 12px; border: 1px solid #a7f3d0;">
                                    <h4 style="color: #065f46; margin-bottom: 15px;"><i class="fa fa-comments"></i> Still need help?</h4>
                                    <p style="color: #065f46; margin-bottom: 20px; font-size: 15px;">
                                        If your question is not listed here, please contact us and our support team will assist you as soon as possible.
                                    </p>
                                    <div class="support-actions">
                                        <a href="contact.php" class="btn btn-success" style="margin-right: 15px;">
                                            <i class="fa fa-envelope"></i> Contact Support
                                        </a>
                                        <a href="faq.php" class="btn btn-outline">
                                            <i class="fa fa-question-circle"></i> More FAQs
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="quick-links" style="background: #fff; border: 1px solid var(--color-neutral-200); border-radius: 12px; padding: 25px;">
                                    <h4 style="margin-bottom: 20px;"><i class="fa fa-link"></i> Quick Links</h4>
                                    <ul style="list-style: none; padding: 0; margin: 0;">
                                        <li style="margin-bottom: 12px;">
                                            <a href="track-order.php" style="color: var(--color-primary); text-decoration: none; display: flex; align-items: center;">
                                                <i class="fa fa-search" style="margin-right: 10px; width: 16px;"></i> Track Your Order
                                            </a>
                                        </li>
                                        <li style="margin-bottom: 12px;">
                                            <a href="shipping-returns.php" style="color: var(--color-primary); text-decoration: none; display: flex; align-items: center;">
                                                <i class="fa fa-truck" style="margin-right: 10px; width: 16px;"></i> Shipping & Returns
                                            </a>
                                        </li>
                                        <li style="margin-bottom: 12px;">
                                            <a href="privacy-policy.php" style="color: var(--color-primary); text-decoration: none; display: flex; align-items: center;">
                                                <i class="fa fa-shield" style="margin-right: 10px; width: 16px;"></i> Privacy Policy
                                            </a>
                                        </li>
                                        <li style="margin-bottom: 12px;">
                                            <a href="tnc.php" style="color: var(--color-primary); text-decoration: none; display: flex; align-items: center;">
                                                <i class="fa fa-file-text" style="margin-right: 10px; width: 16px;"></i> Terms & Conditions
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.faq-question').click(function() {
        var target = $(this).data('target');
        var isExpanded = $(target).hasClass('show');
        
        // Close all FAQ items
        $('.faq-answer').removeClass('show').slideUp(300);
        $('.faq-question i.fa-chevron-down').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        
        // Toggle current item
        if (!isExpanded) {
            $(target).addClass('show').slideDown(300);
            $(this).find('i.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-up');
        }
    });
    
    // Hover effects for FAQ items
    $('.faq-question').hover(
        function() {
            $(this).css('background', '#f1f5f9');
        },
        function() {
            $(this).css('background', 'var(--color-neutral-50)');
        }
    );
});
</script>

<?php require_once('footer.php'); ?>

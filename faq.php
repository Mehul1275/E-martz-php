<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $faq_title = $row['faq_title'];
    $faq_banner = $row['faq_banner'];
}
?>

<div class="page" style="padding-top: 25px;">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <div class="page-header" style="margin-bottom: 30px;">
                    <h1><?php echo $faq_title; ?></h1>
                    <p class="text-muted">Find answers to common questions below. Can't find what you're looking for? <a href="contact.php">Contact us</a>.</p>
                </div>
                
                <!-- <div class="faq-container" style="background:#fff; padding: 30px 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);"> -->
                     <div class="faq-accordion" id="faqAccordion">
                        <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_faq ORDER BY faq_id ASC");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                        foreach ($result as $row) {
                            ?>
                            <div class="faq-item">
                                <div class="faq-question" data-toggle="collapse" data-parent="#faqAccordion" data-target="#question<?php echo $row['faq_id']; ?>" aria-expanded="false">
                                    <h4>
                                        <span class="question-text">
                                            <i class="fa fa-question-circle"></i>
                                            <?php echo $row['faq_title']; ?>
                                        </span>
                                        <i class="fa fa-chevron-down toggle-icon"></i>
                                    </h4>
                                </div>
                                <div id="question<?php echo $row['faq_id']; ?>" class="faq-answer collapse">
                                    <div class="answer-content">
                                        <div class="answer-label">
                                            <i class="fa fa-check-circle"></i> Answer
                                        </div>
                                        <p><?php echo $row['faq_content']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    
                    <div class="faq-help">
                        <div class="help-card">
                            <h3><i class="fa fa-life-ring"></i> Still Need Help?</h3>
                            <p>If you can't find the answer you're looking for, our customer support team is here to help.</p>
                            <div class="help-actions">
                                <a href="contact.php" class="btn btn-primary">
                                    <i class="fa fa-envelope"></i> Contact Support
                                </a>
                                <a href="help.php" class="btn btn-outline">
                                    <i class="fa fa-question-circle"></i> More Help
                                </a>
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
    // Enhanced FAQ accordion functionality
    $('.faq-question').click(function() {
        var target = $(this).data('target');
        var isExpanded = $(this).attr('aria-expanded') === 'true';
        
        // Close all other FAQ items
        $('.faq-question').attr('aria-expanded', 'false');
        $('.faq-answer').removeClass('show').slideUp(300);
        
        // Toggle current item
        if (!isExpanded) {
            $(this).attr('aria-expanded', 'true');
            $(target).addClass('show').slideDown(300);
        }
    });
    
    // Smooth scroll to FAQ item if hash is present
    if (window.location.hash) {
        var hash = window.location.hash;
        if ($(hash).length) {
            setTimeout(function() {
                $('html, body').animate({
                    scrollTop: $(hash).offset().top - 100
                }, 500);
                $(hash).prev('.faq-question').click();
            }, 500);
        }
    }
    
    // Add search functionality for FAQ items
    if ($('.faq-search').length === 0) {
        $('.faq-container').prepend(`
            <div class="faq-search-container" style="margin-bottom: 30px;">
                <div class="input-group">
                    <input type="text" class="form-control faq-search" placeholder="Search FAQ..." style="padding: 15px; border-radius: 10px 0 0 10px; border: 2px solid #e5e7eb; font-size: 16px;">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" style="border-radius: 0 10px 10px 0; padding: 15px 20px;">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        `);
    }
    
    // FAQ search functionality
    $('.faq-search').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase();
        
        $('.faq-item').each(function() {
            var questionText = $(this).find('.faq-question h4').text().toLowerCase();
            var answerText = $(this).find('.answer-content p').text().toLowerCase();
            
            if (questionText.includes(searchTerm) || answerText.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        
        // Show message if no results found
        if ($('.faq-item:visible').length === 0 && searchTerm !== '') {
            if ($('.no-results').length === 0) {
                $('.faq-accordion').append(`
                    <div class="no-results text-center" style="padding: 40px; color: #64748b;">
                        <i class="fa fa-search" style="font-size: 3rem; margin-bottom: 20px; opacity: 0.5;"></i>
                        <h4>No results found</h4>
                        <p>Try searching with different keywords or <a href="contact.php">contact us</a> for help.</p>
                    </div>
                `);
            }
        } else {
            $('.no-results').remove();
        }
    });
});
</script>

<?php require_once('footer.php'); ?>
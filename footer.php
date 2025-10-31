<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/PHPMailer-master/src/Exception.php';

$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
	$footer_about = $row['footer_about'];
	$contact_email = $row['contact_email'];
	$contact_phone = $row['contact_phone'];
	$contact_address = $row['contact_address'];
	$footer_copyright = $row['footer_copyright'];
	$total_recent_post_footer = $row['total_recent_post_footer'];
    $total_popular_post_footer = $row['total_popular_post_footer'];
    $newsletter_on_off = $row['newsletter_on_off'];
    $before_body = $row['before_body'];
}
?>


<?php if($newsletter_on_off == 1): ?>
<!-- Newsletter Section with Blue Gradient -->
<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-content">
            <h2>Stay Updated with E-Martz</h2>
            <p>Get the latest deals, new arrivals, and exclusive offers delivered to your inbox.</p>
            
            <?php
            if(isset($_POST['form_subscribe']))
            {
                $error_message1 = '';
                $success_message1 = '';
                
                if(empty($_POST['email_subscribe'])) 
                {
                    $valid = 0;
                    $error_message1 .= 'Please enter your email address.';
                }
                else
                {
                    if (filter_var($_POST['email_subscribe'], FILTER_VALIDATE_EMAIL) === false)
                    {
                        $valid = 0;
                        $error_message1 .= 'Please enter a valid email address.';
                    }
                    else
                    {
                        $statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_email=?");
                        $statement->execute(array($_POST['email_subscribe']));
                        $total = $statement->rowCount();							
                        if($total)
                        {
                            $valid = 0;
                            $error_message1 .= 'This email is already subscribed.';
                        }
                        else
                        {
                            // Sending email to the requested subscriber for email confirmation
                            $key = md5(uniqid(rand(), true));
                            $current_date = date('Y-m-d');
                            $current_date_time = date('Y-m-d H:i:s');

                            // Inserting data into the database
                            $statement = $pdo->prepare("INSERT INTO tbl_subscriber (subs_email,subs_date,subs_date_time,subs_hash,subs_active) VALUES (?,?,?,?,?)");
                            $statement->execute(array($_POST['email_subscribe'],$current_date,$current_date_time,$key,0));

                            // Sending Confirmation Email
                            $to = $_POST['email_subscribe'];
                            $subject = 'Subscriber Email Confirmation';
                            $verification_url = BASE_URL.'verify.php?email='.$to.'&key='.$key;
                            $message = 'Thanks for your interest to subscribe our newsletter!<br><br>Please click this link to confirm your subscription: '.$verification_url.'<br><br>This link will be active only for 24 hours.';

                            $mail = new PHPMailer(true);
                            try {
                                $mail->isSMTP();
                                $mail->Host       = 'smtp.gmail.com';
                                $mail->SMTPAuth   = true;
                                $mail->Username   = 'emartz6976@gmail.com';
                                $mail->Password   = 'saeq xbcv bhuh tgby';
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                $mail->Port       = 587;
                                $mail->CharSet    = 'UTF-8';

                                $mail->setFrom('emartz6976@gmail.com', 'E-martz');
                                $mail->addAddress($to);
                                $mail->addReplyTo('emartz6976@gmail.com', 'E-martz');

                                $mail->isHTML(true);
                                $mail->Subject = $subject;
                                $mail->Body    = $message;

                                $mail->send();
                                $success_message1 = 'Please check your email to confirm subscription.';
                            } catch (Exception $e) {
                                $error_message1 = 'Email could not be sent. Please try again.';
                            }
                        }
                    }
                }
            }
            ?>
            
            <?php if(isset($error_message1) && $error_message1 != ''): ?>
                <div class="alert alert-danger"><?php echo $error_message1; ?></div>
            <?php endif; ?>
            
            <?php if(isset($success_message1) && $success_message1 != ''): ?>
                <div class="alert alert-success"><?php echo $success_message1; ?></div>
            <?php endif; ?>
            
            <form action="" method="post" class="newsletter-form">
                <?php $csrf->echoInputField(); ?>
                <div class="newsletter-input-group">
                    <input type="email" class="newsletter-input" style="color: black;" placeholder="Enter your email address" name="email_subscribe" required>
                    <button type="submit" class="newsletter-btn" name="form_subscribe">
                        <i class="fa fa-paper-plane"></i> Subscribe
                    </button>
                </div>
                <p class="newsletter-privacy">
                    <i class="fa fa-lock"></i> We respect your privacy. Unsubscribe at any time.
                </p>
            </form>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Main Footer -->
<footer class="main-footer">
    <div class="container">
        <div class="row">
            <!-- About E-martz -->
            <div class="col-md-3 col-sm-6">
                <div class="footer-section">
                    <h4><i class="fa fa-info-circle"></i> About E-Martz</h4>
                    <p>Your trusted online marketplace offering quality products with secure shopping, fast delivery, and excellent customer service.</p>
                    <ul class="footer-links">
                        <li><a href="about.php"><i class="fa fa-users"></i> About Us</a></li>
                        <li><a href="faq.php"><i class="fa fa-question-circle"></i> FAQ</a></li>
                        <li><a href="tnc.php"><i class="fa fa-file-text"></i> Terms & Conditions</a></li>
                        <li><a href="contact.php"><i class="fa fa-envelope"></i> Contact Us</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Customer Service -->
            <div class="col-md-3 col-sm-6">
                <div class="footer-section">
                    <h4><i class="fa fa-headphones"></i> Customer Service</h4>
                    <ul class="footer-links">
                        <li><a href="track-order.php"><i class="fa fa-truck"></i> Track Your Order</a></li>
                        <li><a href="shipping-returns.php"><i class="fa fa-undo"></i> Shipping & Returns</a></li>
                        <li><a href="privacy-policy.php"><i class="fa fa-shield"></i> Privacy Policy</a></li>
                        <li><a href="help.php"><i class="fa fa-life-ring"></i> Help Center</a></li>
                    </ul>
                    <div class="contact-info">
                        <p><i class="fa fa-phone"></i> <?php echo $contact_phone; ?></p>
                        <p><i class="fa fa-envelope"></i> <?php echo $contact_email; ?></p>
                    </div>
                </div>
            </div>
            
            <!-- For Sellers -->
            <div class="col-md-3 col-sm-6">
                <div class="footer-section">
                    <h4><i class="fa fa-store"></i> For Sellers</h4>
                    <ul class="footer-links">
                        <li><a href="seller-registration.php"><i class="fa fa-user-plus"></i> Become a Seller</a></li>
                        <li><a href="seller-login.php"><i class="fa fa-sign-in"></i> Seller Login</a></li>
                        <li><a href="seller-tnc.php"><i class="fa fa-handshake-o"></i> Seller Agreement</a></li>
                    </ul>
                    <p class="seller-note">
                        <i class="fa fa-star"></i> Join thousands of successful sellers on our platform
                    </p>
                </div>
            </div>
            
            <!-- Trust & Security -->
            <div class="col-md-3 col-sm-6">
                <div class="footer-section">
                    <h4><i class="fa fa-shield"></i> Trust & Security</h4>
                    <ul class="footer-links">
                        <li><a href="secure-checkout.php"><i class="fa fa-lock"></i> Secure Checkout</a></li>
                        <li><a href="fast-delivery.php"><i class="fa fa-truck"></i> Fast Delivery</a></li>
                        <li><a href="payment-options.php"><i class="fa fa-credit-card"></i> Payment Options</a></li>
                    </ul>
                    <div class="trust-badges">
                        <div class="trust-item">
                            <i class="fa fa-lock"></i>
                            <span>Secure SSL Encryption</span>
                        </div>
                        <div class="trust-item">
                            <i class="fa fa-credit-card"></i>
                            <span>Safe Payment Methods</span>
                        </div>
                        <div class="trust-item">
                            <i class="fa fa-truck"></i>
                            <span>Fast & Reliable Delivery</span>
                        </div>
                        <div class="trust-item">
                            <i class="fa fa-phone"></i>
                            <span>24/7 Customer Support</span>
                        </div>
                    </div>
                    
                    <div class="social-links">
                        <h5>Follow Us</h5>
                        <div class="social-icons">
                            <?php
                            $statement = $pdo->prepare("SELECT * FROM tbl_social");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                if($row['social_url'] != '') {
                                    echo '<a href="'.htmlspecialchars($row['social_url']).'" target="_blank"><i class="'.htmlspecialchars($row['social_icon']).'"></i></a>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


<div class="footer-bottom">
	<div class="container">
		<div class="row">
			<div class="col-md-12 copyright" style="display: flex; justify-content: center; align-items: center;">
				<span><?php echo $footer_copyright; ?></span>
			</div>
		</div>
	</div>
</div>


<a href="#" class="scrollup">
	<i class="fa fa-angle-up"></i>
</a>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $stripe_public_key = $row['stripe_public_key'];
    $stripe_secret_key = $row['stripe_secret_key'];
}
?>

<script src="assets/js/jquery-2.2.4.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="https://js.stripe.com/v2/"></script>
<script src="assets/js/megamenu.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/owl.animate.js"></script>
<script src="assets/js/jquery.bxslider.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/rating.js"></script>
<script src="assets/js/jquery.touchSwipe.min.js"></script>
<script src="assets/js/bootstrap-touch-slider.js"></script>
<script src="assets/js/select2.full.min.js"></script>
<script src="assets/js/custom.js"></script>
<script>
	function confirmDelete()
	{
	    return confirm("Sure you want to delete this data?");
	}
	$(document).ready(function () {
		advFieldsStatus = $('#advFieldsStatus').val();

		$('#paypal_form').hide();
		$('#stripe_form').hide();
		$('#bank_form').hide();

        $('#advFieldsStatus').on('change',function() {
            advFieldsStatus = $('#advFieldsStatus').val();
            if ( advFieldsStatus == '' ) {
            	$('#paypal_form').hide();
				$('#stripe_form').hide();
				$('#bank_form').hide();
            } else if ( advFieldsStatus == 'PayPal' ) {
               	$('#paypal_form').show();
				$('#stripe_form').hide();
				$('#bank_form').hide();
            } else if ( advFieldsStatus == 'Stripe' ) {
               	$('#paypal_form').hide();
				$('#stripe_form').show();
				$('#bank_form').hide();
            } else if ( advFieldsStatus == 'Bank Deposit' ) {
            	$('#paypal_form').hide();
				$('#stripe_form').hide();
				$('#bank_form').show();
            }
        });
	});


	$(document).on('submit', '#stripe_form', function () {
        // createToken returns immediately - the supplied callback submits the form if there are no errors
        $('#submit-button').prop("disabled", true);
        $("#msg-container").hide();
        Stripe.card.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
            // name: $('.card-holder-name').val()
        }, stripeResponseHandler);
        return false;
    });
    Stripe.setPublishableKey('<?php echo $stripe_public_key; ?>');
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('#submit-button').prop("disabled", false);
            $("#msg-container").html('<div style="color: red;border: 1px solid;margin: 10px 0px;padding: 5px;"><strong>Error:</strong> ' + response.error.message + '</div>');
            $("#msg-container").show();
        } else {
            var form$ = $("#stripe_form");
            var token = response['id'];
            form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
            form$.get(0).submit();
        }
    }
</script>
<?php // echo $before_body; ?>
</body>
</html>
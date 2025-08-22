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
<section class="home-newsletter">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="single">
					<?php
			if(isset($_POST['form_subscribe']))
			{

				if(empty($_POST['email_subscribe'])) 
			    {
			        $valid = 0;
			        $error_message1 .= LANG_VALUE_131;
			    }
			    else
			    {
			    	if (filter_var($_POST['email_subscribe'], FILTER_VALIDATE_EMAIL) === false)
				    {
				        $valid = 0;
				        $error_message1 .= LANG_VALUE_134;
				    }
				    else
				    {
				    	$statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_email=?");
				    	$statement->execute(array($_POST['email_subscribe']));
				    	$total = $statement->rowCount();							
				    	if($total)
				    	{
				    		$valid = 0;
				        	$error_message1 .= LANG_VALUE_147;
				    	}
				    	else
				    	{
				    		// Sending email to the requested subscriber for email confirmation
				    		// Getting activation key to send via email. also it will be saved to database until user click on the activation link.
				    		$key = md5(uniqid(rand(), true));

				    		// Getting current date
				    		$current_date = date('Y-m-d');

				    		// Getting current date and time
				    		$current_date_time = date('Y-m-d H:i:s');

				    		// Inserting data into the database
				    		$statement = $pdo->prepare("INSERT INTO tbl_subscriber (subs_email,subs_date,subs_date_time,subs_hash,subs_active) VALUES (?,?,?,?,?)");
				    		$statement->execute(array($_POST['email_subscribe'],$current_date,$current_date_time,$key,0));

				    		// Sending Confirmation Email
				    		$to = $_POST['email_subscribe'];
							$subject = 'Subscriber Email Confirmation';
							
							// Getting the url of the verification link
							$verification_url = BASE_URL.'verify.php?email='.$to.'&key='.$key;

							$message = '
Thanks for your interest to subscribe our newsletter!<br><br>
Please click this link to confirm your subscription:
					'.$verification_url.'<br><br>
This link will be active only for 24 hours.
					';

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
								$success_message1 = LANG_VALUE_136;
							} catch (Exception $e) {
								$error_message1 = 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
							}
				    	}
				    }
			    }
			}
			if($error_message1 != '') {
				echo "<script>alert('".$error_message1."')</script>";
			}
			if($success_message1 != '') {
				echo "<script>alert('".$success_message1."')</script>";
			}
			?>
				<form action="" method="post">
					<?php $csrf->echoInputField(); ?>
					<h2><?php echo LANG_VALUE_93; ?></h2>
					<div class="input-group">
			        	<input type="email" class="form-control" placeholder="<?php echo LANG_VALUE_95; ?>" name="email_subscribe">
			         	<span class="input-group-btn">
			         	<button class="btn btn-theme" type="submit" name="form_subscribe"><?php echo LANG_VALUE_92; ?></button>
			         	</span>
			        </div>
				</div>
				</form>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- BEGIN: Custom 4-column footer -->
<div class="footer-main" style="background:#232f3e;color:#fff;padding:40px 0 20px 0;">
  <div class="container">
    <div class="row">
      <!-- About E-mart -->
      <div class="col-md-3 col-sm-6 mb-4">
        <h4 style="color:#fff;">About E-mart</h4>
        <ul style="list-style:none;padding:0;line-height:2;">
          <li><a href="about.php" style="color:#fff;">About Us</a></li>
          <li><a href="faq.php" style="color:#fff;">FAQ</a></li>
          <li><a href="tnc.php" style="color:#fff;">Terms & Conditions</a></li>
          <li><a href="contact.php" style="color:#fff;">Contact</a></li>
        </ul>
      </div>
      <!-- Contact Us -->
      <div class="col-md-3 col-sm-6 mb-4">
        <h4 style="color:#fff;">Contact Us</h4>
        <ul style="list-style:none;padding:0;line-height:2;">
          <li><i class="fa fa-phone"></i> <?php echo $contact_phone; ?></li>
          <li><i class="fa fa-envelope"></i> <a href="mailto:<?php echo $contact_email; ?>" style="color:#fff;"><?php echo $contact_email; ?></a></li>
        </ul>
      </div>
      <!-- Useful Links -->
      <div class="col-md-3 col-sm-6 mb-4">
        <h4 style="color:#fff;">Useful Links</h4>
        <ul style="list-style:none;padding:0;line-height:2;">
          <li><a href="customer-order.php" style="color:#fff;">Your Orders</a></li>
          <li><a href="shipping-returns.php" style="color:#fff;">Shipping & Returns</a></li>
          <li><a href="privacy-policy.php" style="color:#fff;">Privacy Policy</a></li>
          <li><a href="faq.php" style="color:#fff;">Help</a></li>
        </ul>
      </div>
      <!-- Become Seller -->
      <div class="col-md-3 col-sm-6 mb-4">
        <h4 style="color:#fff;">Become Seller</h4>
        <ul style="list-style:none;padding:0;line-height:2;">
          <li><a href="seller-login.php" style="color:#fff;">Seller Login</a></li>
          <li><a href="seller-registration.php" style="color:#fff;">New Seller? Sign Up</a></li>
          <!-- <li><a href="seller-dashboard.php" style="color:#fff;">Seller Dashboard</a></li> -->
                             <li><a href="seller-tnc.php" style="color:#fff;">Seller T&C</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- END: Custom 4-column footer -->

<!-- Social Media Footer Row -->
<div class="footer-social" style="background:#232f3e;padding-bottom:20px;">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <div style="margin:10px 0;">
          <?php
          $statement = $pdo->prepare("SELECT * FROM tbl_social");
          $statement->execute();
          $result = $statement->fetchAll(PDO::FETCH_ASSOC);
          foreach ($result as $row) {
            if($row['social_url'] != '') {
              echo '<a href="'.htmlspecialchars($row['social_url']).'" target="_blank" style="display:inline-block;margin:0 8px;color:#fff;font-size:22px;"><i class="'.htmlspecialchars($row['social_icon']).'"></i></a>';
            }
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>


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
<?php require_once('header.php'); ?>

<style>
.error-msg{color:#e74c3c;font-size:12px;margin-top:6px;display:none;opacity:0;transition:opacity .2s ease}
.invalid{border-color:#e74c3c !important}
.error-msg.show{display:block;opacity:1}
</style>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $contact_title = $row['contact_title'];
    $contact_banner = $row['contact_banner'];
}
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $contact_map_iframe = $row['contact_map_iframe'];
    $contact_email = $row['contact_email'];
    $contact_phone = $row['contact_phone'];
    $contact_address = $row['contact_address'];
}
?>

<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <div class="page-header">
                    <h1><?php echo $contact_title; ?></h1>
                    <p class="text-muted">We usually respond within 24 hours. Get in touch with us!</p>
                </div>
                
                <?php
                // After form submit checking everything for email sending
                if(isset($_POST['form_contact']))
                {
                    $error_message = '';
                    $success_message = '';
                    $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
                    foreach ($result as $row) 
                    {
                        $receive_email = $row['receive_email'];
                        $receive_email_subject = $row['receive_email_subject'];
                        $receive_email_thank_you_message = $row['receive_email_thank_you_message'];
                    }

                    $valid = 1;

                    if(empty($_POST['visitor_name']))
                    {
                        $valid = 0;
                        $error_message .= 'Please enter your name.\n';
                    } else {
                        // Name: only letters and spaces, min 3 chars
                        if(!preg_match('/^[A-Za-z ]{3,}$/', $_POST['visitor_name'])){
                            $valid = 0;
                            $error_message .= 'Name must be at least 3 letters and spaces only.\n';
                        }
                    }

                    if(empty($_POST['visitor_phone']))
                    {
                        $valid = 0;
                        $error_message .= 'Please enter your phone number.\n';
                    } else {
                        // Phone: exactly 10 digits
                        if(!preg_match('/^\d{10}$/', $_POST['visitor_phone'])){
                            $valid = 0;
                            $error_message .= 'Phone number must be exactly 10 digits.\n';
                        }
                    }

                    if(empty($_POST['visitor_email']))
                    {
                        $valid = 0;
                        $error_message .= 'Please enter your email address.\n';
                    }
                    else
                    {
                        // Email validation check
                        if(!filter_var($_POST['visitor_email'], FILTER_VALIDATE_EMAIL))
                        {
                            $valid = 0;
                            $error_message .= 'Please enter a valid email address.\n';
                        }
                    }

                    if(empty($_POST['visitor_message']))
                    {
                        $valid = 0;
                        $error_message .= 'Please enter your message.\n';
                    } else {
                        // Message: minimum 10 characters
                        if(strlen(trim($_POST['visitor_message'])) < 10){
                            $valid = 0;
                            $error_message .= 'Message must be at least 10 characters long.\n';
                        }
                    }

                    if($valid == 1)
                    {
                        $visitor_name = strip_tags($_POST['visitor_name']);
                        $visitor_email = strip_tags($_POST['visitor_email']);
                        $visitor_phone = strip_tags($_POST['visitor_phone']);
                        $visitor_message = strip_tags($_POST['visitor_message']);

                        // Insert into database
                        $statement = $pdo->prepare("INSERT INTO tbl_contact_messages (name, email, phone, message, is_read, created_at) VALUES (?, ?, ?, ?, 0, NOW())");
                        $statement->execute([
                            $visitor_name,
                            $visitor_email,
                            $visitor_phone,
                            $visitor_message
                        ]);

                        // sending email
                        /*
                        $to_admin = $receive_email;
                        $subject = $receive_email_subject;
                        $message = '
                <html><body>
                <table>
                <tr>
                <td>Name</td>
                <td>'.$visitor_name.'</td>
                </tr>
                <tr>
                <td>Email</td>
                <td>'.$visitor_email.'</td>
                </tr>
                <tr>
                <td>Phone</td>
                <td>'.$visitor_phone.'</td>
                </tr>
                <tr>
                <td>Comment</td>
                <td>'.nl2br($visitor_message).'</td>
                </tr>
                </table>
                </body></html>
                ';
                        $headers = 'From: ' . $visitor_email . "\r\n" .
                                   'Reply-To: ' . $visitor_email . "\r\n" .
                                   'X-Mailer: PHP/' . phpversion() . "\r\n" . 
                                   "MIME-Version: 1.0\r\n" . 
                                   "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        // Sending email to admin                  
                        // mail($to_admin, $subject, $message, $headers); 
                        */
                        $success_message = $receive_email_thank_you_message;
                    }
                }
                ?>
                
                <?php if($error_message != ''): ?>
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle"></i>
                        <?php echo nl2br($error_message); ?>
                    </div>
                <?php endif; ?>
                
                <?php if($success_message != ''): ?>
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle"></i>
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-8">
                        <div class="contact-form-card">
                            <div class="card-header">
                                <h3><i class="fa fa-envelope" style="color: white;"></i> <span style="color: white;">Send us a Message</span></h3>
                                <p><span style="color: white;">Fill out the form below and we'll get back to you as soon as possible.</span> <br> <span style="color: white;">We usually respond within 24 hours.</span></p>
                            </div>
                            <form action="" method="post" class="contact-form">
                                <?php $csrf->echoInputField(); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="visitor_name"><i class="fa fa-user"></i> Full Name *</label>
                                            <input type="text" class="form-control" name="visitor_name" id="visitor_name" placeholder="Enter your full name" >
                                            <span class="error-msg" id="visitor_name_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="visitor_email"><i class="fa fa-envelope"></i> Email Address *</label>
                                            <input type="email" class="form-control" name="visitor_email" id="visitor_email" placeholder="Enter your email address" >
                                            <span class="error-msg" id="visitor_email_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="visitor_phone"><i class="fa fa-phone"></i> Phone Number *</label>
                                            <input type="text" class="form-control" name="visitor_phone" id="visitor_phone" placeholder="Enter your phone number"  maxlength="10" inputmode="numeric" pattern="\d{10}" oninput="this.value=this.value.replace(/\D/g,'').slice(0,10)">
                                            <span class="error-msg" id="visitor_phone_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="visitor_message"><i class="fa fa-comment"></i> Message *</label>
                                            <textarea name="visitor_message" id="visitor_message" class="form-control" rows="6" placeholder="Enter your message here..." ></textarea>
                                            <span class="error-msg" id="visitor_message_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-lg" name="form_contact">
                                            <i class="fa fa-paper-plane"></i> Send Message
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-info-card">
                            <div class="card-header">
                                <h3><i class="fa fa-map-marker" style="color: white;"></i> <span style="color: white;">Contact Information</span></h3>
                            </div>
                            <div class="contact-info">
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <div class="contact-details">
                                        <h4>Address</h4>
                                        <p><?php echo nl2br($contact_address); ?></p>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <div class="contact-details">
                                        <h4>Phone</h4>
                                        <p><a href="tel:<?php echo $contact_phone; ?>"><?php echo $contact_phone; ?></a></p>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <div class="contact-details">
                                        <h4>Email</h4>
                                        <p><a href="mailto:<?php echo $contact_email; ?>"><?php echo $contact_email; ?></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="map-section">
                    <h3><i class="fa fa-map"></i> Find Us On Map</h3>
                    <div class="map-container">
                        <?php echo $contact_map_iframe; ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>

<script>
(function(){
    function setError(el, msg){
        var err = document.getElementById(el.id + '_error');
        if(err){ err.textContent = msg || ''; err.classList.toggle('show', !!msg); }
        el.classList.toggle('invalid', !!msg);
    }
    function validateName(){
        var el = document.getElementById('visitor_name');
        var v = el.value.trim();
        if(!/^[A-Za-z ]{3,}$/.test(v)) return setError(el,'Enter at least 3 letters (letters and spaces only).'), false;
        return setError(el,''), true;
    }
    function validateEmail(){
        var el = document.getElementById('visitor_email');
        var v = el.value.trim();
        var ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
        return setError(el, ok?'':'Enter a valid email address.'), ok;
    }
    function validatePhone(){
        var el = document.getElementById('visitor_phone');
        var ok = /^\d{10}$/.test(el.value.trim());
        return setError(el, ok?'':'Enter a 10-digit phone number.'), ok;
    }
    function validateMessage(){
        var el = document.getElementById('visitor_message');
        var ok = el.value.trim().length >= 10;
        return setError(el, ok?'':'Message must be at least 10 characters.'), ok;
    }
    var form = document.querySelector('form.contact-form');
    if(!form) return;
    ['visitor_name','visitor_email','visitor_phone','visitor_message'].forEach(function(id){
        var el = document.getElementById(id);
        if(!el) return;
        el.addEventListener('input', function(){
            switch(id){
                case 'visitor_name': validateName(); break;
                case 'visitor_email': validateEmail(); break;
                case 'visitor_phone': validatePhone(); break;
                case 'visitor_message': validateMessage(); break;
            }
        });
    });
    form.addEventListener('submit', function(e){
        var ok = [validateName(), validateEmail(), validatePhone(), validateMessage()].every(Boolean);
        if(!ok){ e.preventDefault(); }
    });
})();
</script>
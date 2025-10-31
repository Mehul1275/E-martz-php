<?php
declare(strict_types=1);

// Start output buffering and session
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include configuration files
require_once("inc/config.php");
require_once("inc/functions.php");
require_once("inc/CSRF_Protect.php");

// Initialize CSRF protection
$csrf = new CSRF_Protect();
$error_message = '';

if(isset($_POST['form1'])) {
        
    if(empty($_POST['email']) || empty($_POST['password'])) {
        $error_message = 'Email and/or Password can not be empty<br>';
    } else {
		
		$email = sanitize_input($_POST['email']);
		$password = $_POST['password']; // Don't sanitize password before verification

		// Extra backend validation for email format
		if(!validate_email($email)){
			$error_message .= 'Please enter a valid email address.<br>';
		}

        $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email=? AND status=?");
        $statement->execute([$email, 'Active']);
        $total = $statement->rowCount();  
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);  

        if($total == 0) {
            $error_message .= 'Email Address does not match<br>';
        } else {       
            $row = $result[0];
            $row_password = $row['password'];
        
            if (verify_password($password, $row_password)) {
                $_SESSION['user'] = $row;
                header("location: index.php");
                exit();
            } else if (hash_equals($row_password, md5($password))) {
                // Legacy md5 check - upgrade to password_hash
                $_SESSION['user'] = $row;
                // Upgrade to password_hash
                $new_hash = hash_password($password);
                $statement = $pdo->prepare("UPDATE tbl_user SET password=? WHERE email=?");
                $statement->execute([$new_hash, $email]);
                $_SESSION['user']['password'] = $new_hash;
                header("location: index.php");
                exit();
            } else {
                $error_message .= 'Password does not match<br>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">

	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="css/modern-admin.css">
	
	<style>
	body.login-page {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		font-family: 'Inter', sans-serif;
		min-height: 100vh;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0;
		padding: 2rem;
		position: relative;
		overflow: hidden;
	}
	
	body.login-page::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
		animation: float 20s ease-in-out infinite;
	}
	
	@keyframes float {
		0%, 100% { transform: translateY(0px); }
		50% { transform: translateY(-20px); }
	}
	
	.login-box {
		width: 100%;
		max-width: 450px;
		position: relative;
		z-index: 1;
		animation: slideInUp 0.8s ease-out;
	}
	
	@keyframes slideInUp {
		from {
			opacity: 0;
			transform: translateY(50px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}
	
	.login-logo {
		text-align: center;
		margin-bottom: 3rem;
	}
	
	.login-logo b {
		color: white;
		font-size: 2.5rem;
		font-weight: 700;
		text-shadow: 0 4px 8px rgba(0,0,0,0.3);
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 1rem;
	}
	
	.login-logo .logo-icon {
		background: rgba(255, 255, 255, 0.2);
		padding: 1rem;
		border-radius: 50%;
		backdrop-filter: blur(10px);
		border: 2px solid rgba(255, 255, 255, 0.3);
	}
	
	.login-box-body {
		background: rgba(255, 255, 255, 0.95);
		padding: 3rem;
		border-radius: 1.5rem;
		box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
		backdrop-filter: blur(20px);
		border: 1px solid rgba(255, 255, 255, 0.2);
		position: relative;
	}
	
	.login-box-body::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		height: 4px;
		background: linear-gradient(90deg, #667eea, #764ba2);
		border-radius: 1.5rem 1.5rem 0 0;
	}
	
	.login-box-msg {
		text-align: center;
		margin-bottom: 2.5rem;
		color: #64748b;
		font-weight: 500;
		font-size: 1.1rem;
	}
	
	.form-group {
		margin-bottom: 1.5rem;
		position: relative;
	}
	
	.form-control {
		border: 2px solid #e5e7eb;
		border-radius: 0.75rem;
		padding: 1rem 1rem 1rem 3rem;
		font-size: 1rem;
		transition: all 0.3s ease;
		background: #f9fafb;
		width: 100%;
		box-sizing: border-box;
	}
	
	.form-control:focus {
		border-color: #667eea;
		box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
		background: white;
		outline: none;
	}
	
	.input-icon {
		position: absolute;
		left: 1rem;
		top: 50%;
		transform: translateY(-50%);
		color: #9ca3af;
		font-size: 1.1rem;
		z-index: 2;
	}
	
	.form-control:focus + .input-icon {
		color: #667eea;
	}
	
	.login-button {
		background: linear-gradient(135deg, #667eea, #764ba2);
		border: none;
		border-radius: 0.75rem;
		padding: 1rem 2rem;
		font-weight: 600;
		font-size: 1rem;
		transition: all 0.3s ease;
		width: 100%;
		color: white;
		cursor: pointer;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 0.5rem;
	}
	
	.login-button:hover {
		transform: translateY(-2px);
		box-shadow: 0 15px 35px -5px rgba(102, 126, 234, 0.4);
		background: linear-gradient(135deg, #5a67d8, #6b46c1);
	}
	
	.login-button:active {
		transform: translateY(0);
	}
	
	.error {
		background: linear-gradient(135deg, #fef2f2, #fdf2f8);
		border: 2px solid #fecaca;
		color: #dc2626;
		padding: 1rem;
		border-radius: 0.75rem;
		margin-bottom: 1.5rem;
		display: flex;
		align-items: center;
		gap: 0.5rem;
		font-weight: 500;
		animation: shake 0.5s ease-in-out;
	}
	
	@keyframes shake {
		0%, 100% { transform: translateX(0); }
		25% { transform: translateX(-5px); }
		75% { transform: translateX(5px); }
	}

	/* validation helpers */
	.error-msg{color:#e74c3c;font-size:12px;margin-top:6px;display:none;opacity:0;transition:opacity .2s ease}
	.invalid{border-color:#e74c3c !important}
	.error-msg.show{display:block;opacity:1}
	
	.security-note {
		text-align: center;
		margin-top: 2rem;
		color: #6b7280;
		font-size: 0.875rem;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 0.5rem;
	}
	
	@media (max-width: 768px) {
		body.login-page {
			padding: 1rem;
		}
		
		.login-box-body {
			padding: 2rem;
		}
		
		.login-logo b {
			font-size: 2rem;
		}
	}
	</style>
</head>

<body class="hold-transition login-page sidebar-mini">

<div class="login-box">
	<div class="login-logo">
		<b>
			<div class="logo-icon">
				<i class="fa fa-shield"></i>
			</div>
			Admin Panel
		</b>
	</div>
  	<div class="login-box-body">
    	<p class="login-box-msg">
    		<i class="fa fa-lock"></i>
    		Secure Admin Access
    	</p>
    
	    <?php 
	    if( (isset($error_message)) && ($error_message != '') ):
	        echo '<div class="error"><i class="fa fa-exclamation-triangle"></i>'.$error_message.'</div>';
	    endif;
	    ?>

		<form action="" method="post">
			<?php $csrf->echoInputField(); ?>
			<div class="form-group">
				<input class="form-control" placeholder="Email address" name="email" id="email" type="email" autocomplete="off" autofocus >
				<span class="error-msg" id="email_error"></span>
				<i class="fa fa-envelope input-icon"></i>
			</div>
			<div class="form-group">
				<input class="form-control" placeholder="Password" name="password" id="password" type="password" autocomplete="off" value="" >
				<span class="error-msg" id="password_error"></span>
				<i class="fa fa-lock input-icon"></i>
			</div>
			<div class="form-group">
				<button type="submit" class="login-button" name="form1">
					<i class="fa fa-sign-in"></i>
					Sign In to Dashboard
				</button>
			</div>
		</form>
		
		<div class="security-note">
			<i class="fa fa-info-circle"></i>
			Protected by advanced security measures
		</div>
	</div>
</div>


<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/select2.full.min.js"></script>
<script src="js/jquery.inputmask.js"></script>
<script src="js/jquery.inputmask.date.extensions.js"></script>
<script src="js/jquery.inputmask.extensions.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/icheck.min.js"></script>
<script src="js/fastclick.js"></script>
<script src="js/jquery.sparkline.min.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<script src="js/app.min.js"></script>
<script src="js/demo.js"></script>

<script>
(function(){
    function setError(el, msg){
        var err = document.getElementById(el.id + '_error');
        if(err){ err.textContent = msg || ''; err.classList.toggle('show', !!msg); }
        el.classList.toggle('invalid', !!msg);
    }
    function validateUsername(){
        var el = document.getElementById('email');
        var v = el.value.trim();
        // Admin currently uses email as username; ensure valid email
        var ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
        return setError(el, ok?'':'Enter a valid email.'), ok;
    }
    function validatePassword(){
        var el = document.getElementById('password');
        var ok = el.value.length > 0;
        return setError(el, ok?'':'Password cannot be blank.'), ok;
    }
    var form = document.querySelector('form[action=""][method="post"]');
    if(!form) return;
    ['email','password'].forEach(function(id){
        var el = document.getElementById(id);
        if(!el) return;
        el.addEventListener('input', function(){
            if(id==='email') validateUsername();
            if(id==='password') validatePassword();
        });
    });
    form.addEventListener('submit', function(e){
        var ok = [validateUsername(), validatePassword()].every(Boolean);
        if(!ok){ e.preventDefault(); }
    });
})();
</script>

</body>
</html>
<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {

	if(isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : 'Admin' == 'Super Admin') {

		$valid = 1;

	    if(empty($_POST['full_name'])) {
	        $valid = 0;
	        $error_message .= "Name can not be empty<br>";
	    }

	    if(empty($_POST['email'])) {
	        $valid = 0;
	        $error_message .= 'Email address can not be empty<br>';
	    } else {
	    	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
		        $valid = 0;
		        $error_message .= 'Email address must be valid<br>';
		    } else {
		    	// current email address that is in the database
		    	$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
				$statement->execute(array($_SESSION['user']['id']));
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);
				foreach($result as $row) {
					$current_email = $row['email'];
				}

		    	$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email=? and email!=?");
		    	$statement->execute(array($_POST['email'],$current_email));
		    	$total = $statement->rowCount();							
		    	if($total) {
		    		$valid = 0;
		        	$error_message .= 'Email address already exists<br>';
		    	}
		    }
	    }

	    if($valid == 1) {
			
			$_SESSION['user']['full_name'] = $_POST['full_name'];
	    	$_SESSION['user']['email'] = $_POST['email'];

			// updating the database
			$statement = $pdo->prepare("UPDATE tbl_user SET full_name=?, email=?, phone=? WHERE id=?");
			$statement->execute(array($_POST['full_name'],$_POST['email'],$_POST['phone'],$_SESSION['user']['id']));

	    	$success_message = 'User Information is updated successfully.';
	    }
	}
	else {
		$_SESSION['user']['phone'] = $_POST['phone'];

		// updating the database
		$statement = $pdo->prepare("UPDATE tbl_user SET phone=? WHERE id=?");
		$statement->execute(array($_POST['phone'],$_SESSION['user']['id']));

		$success_message = 'User Information is updated successfully.';	
	}
}

if(isset($_POST['form2'])) {

	$valid = 1;

	$path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {

    	// removing the existing photo
    	if($_SESSION['user']['photo']!='') {
    		unlink('../assets/uploads/'.$_SESSION['user']['photo']);	
    	}

    	// updating the data
    	$final_name = 'user-'.$_SESSION['user']['id'].'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
        $_SESSION['user']['photo'] = $final_name;

        // updating the database
		$statement = $pdo->prepare("UPDATE tbl_user SET photo=? WHERE id=?");
		$statement->execute(array($final_name,$_SESSION['user']['id']));

        $success_message = 'User Photo is updated successfully.';
    	
    }
}

if(isset($_POST['form3'])) {
	$valid = 1;

	if( empty($_POST['password']) || empty($_POST['re_password']) ) {
        $valid = 0;
        $error_message .= "Password can not be empty<br>";
    }

    if( !empty($_POST['password']) && !empty($_POST['re_password']) ) {
    	if($_POST['password'] != $_POST['re_password']) {
	    	$valid = 0;
	        $error_message .= "Passwords do not match<br>";	
    	}        
    }

    if($valid == 1) {

    	$_SESSION['user']['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

    	// updating the database
		$statement = $pdo->prepare("UPDATE tbl_user SET password=? WHERE id=?");
		$statement->execute(array($_SESSION['user']['password'],$_SESSION['user']['id']));

    	$success_message = 'User Password is updated successfully.';
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
$statement->execute(array($_SESSION['user']['id']));
$statement->rowCount();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$full_name = $row['full_name'];
	$email     = $row['email'];
	$phone     = $row['phone'];
	$photo     = $row['photo'];
	$status    = $row['status'];
	$role      = $row['role'];
}
?>

<style>
.modern-profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 1rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 25px -3px rgba(102, 126, 234, 0.3);
    animation: fadeIn 0.6s ease-out;
}

.modern-profile-header h1 {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.modern-profile-header .subtitle {
    margin-top: 0.5rem;
    opacity: 0.9;
    font-size: 1.1rem;
}

.modern-nav-tabs {
    border: none;
    background: white;
    border-radius: 1rem;
    padding: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
    animation: slideIn 0.8s ease-out;
}

.modern-nav-tabs .nav-tabs {
    border-bottom: none;
    display: flex;
    gap: 0.5rem;
}

.modern-nav-tabs .nav-tabs li {
    margin-bottom: 0;
}

.modern-nav-tabs .nav-tabs li a {
    background: #f8fafc;
    border: 2px solid #e5e7eb;
    border-radius: 0.75rem;
    color: #64748b;
    font-weight: 600;
    padding: 1rem 1.5rem;
    transition: all 0.3s ease;
    margin-right: 0;
}

.modern-nav-tabs .nav-tabs li.active a,
.modern-nav-tabs .nav-tabs li a:hover {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-color: #667eea;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.modern-form-container {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
}

.modern-form-group {
    margin-bottom: 2rem;
}

.modern-form-group label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.modern-form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.5rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.modern-form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: white;
}

.modern-btn {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.modern-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -3px rgba(102, 126, 234, 0.4);
    color: white;
}

.profile-photo-container {
    text-align: center;
    margin-bottom: 2rem;
}

.profile-photo {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #667eea;
    box-shadow: 0 8px 25px -3px rgba(102, 126, 234, 0.3);
}

.role-badge {
    display: inline-block;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-weight: 600;
    font-size: 0.875rem;
}

.readonly-field {
    background: #f3f4f6;
    color: #6b7280;
    border: 2px solid #e5e7eb;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    font-weight: 500;
}

.file-input-container {
    position: relative;
    display: inline-block;
    cursor: pointer;
    width: 100%;
}

.file-input-container input[type="file"] {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.file-input-label {
    display: block;
    padding: 0.75rem 1rem;
    background: #f9fafb;
    border: 2px dashed #d1d5db;
    border-radius: 0.5rem;
    text-align: center;
    color: #6b7280;
    font-weight: 500;
    transition: all 0.3s ease;
}

.file-input-container:hover .file-input-label {
    border-color: #667eea;
    background: #f0f4ff;
    color: #667eea;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 768px) {
    .modern-nav-tabs .nav-tabs {
        flex-direction: column;
    }
    
    .modern-nav-tabs .nav-tabs li a {
        text-align: center;
    }
}
</style>

<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-user-circle"></i>
        Admin Profile
    </h1>
    <div class="subtitle">Manage your account information and settings</div>
</div>

<div class="modern-nav-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-user"></i> Personal Information</a></li>
        <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-camera"></i> Profile Photo</a></li>
        <li><a href="#tab_3" data-toggle="tab"><i class="fa fa-lock"></i> Change Password</a></li>
    </ul>
    
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <div class="modern-form-container">
                <div class="profile-photo-container">
                    <img src="../assets/uploads/<?php echo htmlspecialchars($photo); ?>" class="profile-photo" alt="Profile Photo">
                </div>
                
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label for="full_name">Full Name <span style="color: #ef4444;">*</span></label>
                                <?php if(isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : 'Admin' == 'Super Admin'): ?>
                                    <input type="text" class="modern-form-control" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required>
                                <?php else: ?>
                                    <div class="readonly-field"><?php echo htmlspecialchars($full_name); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label for="email">Email Address <span style="color: #ef4444;">*</span></label>
                                <?php if(isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : 'Admin' == 'Super Admin'): ?>
                                    <input type="email" class="modern-form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                                <?php else: ?>
                                    <div class="readonly-field"><?php echo htmlspecialchars($email); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" class="modern-form-control" name="phone" value="<?php echo htmlspecialchars($phone); ?>" maxlength="10" inputmode="numeric" pattern="\d{10}" oninput="this.value=this.value.replace(/\D/g,'').slice(0,10)">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label for="role">Role</label>
                                <div class="role-badge">
                                    <i class="fa fa-shield"></i> <?php echo htmlspecialchars($role); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modern-form-group">
                        <button type="submit" class="modern-btn" name="form1">
                            <i class="fa fa-save"></i> Update Information
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="tab-pane" id="tab_2">
            <div class="modern-form-container">
                <div class="profile-photo-container">
                    <img src="../assets/uploads/<?php echo htmlspecialchars($photo); ?>" class="profile-photo" alt="Current Profile Photo">
                    <div style="margin-top: 1rem; color: #6b7280; font-size: 0.875rem;">Current Profile Photo</div>
                </div>
                
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="modern-form-group">
                        <label for="photo">Upload New Photo</label>
                        <div class="file-input-container">
                            <input type="file" name="photo" accept="image/*">
                            <div class="file-input-label">
                                <i class="fa fa-cloud-upload"></i> Choose a new profile photo
                                <div style="font-size: 0.875rem; margin-top: 0.5rem;">JPG, PNG, GIF files accepted</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modern-form-group">
                        <button type="submit" class="modern-btn" name="form2">
                            <i class="fa fa-camera"></i> Update Photo
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="tab-pane" id="tab_3">
            <div class="modern-form-container">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="modern-form-control" name="password" placeholder="Enter new password">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label for="re_password">Confirm Password</label>
                                <input type="password" class="modern-form-control" name="re_password" placeholder="Confirm new password">
                            </div>
                        </div>
                    </div>
                    
                    <div class="modern-form-group">
                        <button type="submit" class="modern-btn" name="form3">
                            <i class="fa fa-lock"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
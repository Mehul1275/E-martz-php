<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['tcat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a top level category<br>";
    }

    if(empty($_POST['mcat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a mid level category<br>";
    }

    if(empty($_POST['ecat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select an end level category<br>";
    }

    if(empty($_POST['p_name'])) {
        $valid = 0;
        $error_message .= "Product name can not be empty<br>";
    }

    if(empty($_POST['p_current_price'])) {
        $valid = 0;
        $error_message .= "Current Price can not be empty<br>";
    }

    if(empty($_POST['p_qty'])) {
        $valid = 0;
        $error_message .= "Quantity can not be empty<br>";
    }

    $path = $_FILES['p_featured_photo']['name'];
    $path_tmp = $_FILES['p_featured_photo']['tmp_name'];

    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }


    if($valid == 1) {

    	if( isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmp_name"]) )
        {
        	$photo = array();
            $photo = $_FILES['photo']["name"];
            $photo = array_values(array_filter($photo));

        	$photo_temp = array();
            $photo_temp = $_FILES['photo']["tmp_name"];
            $photo_temp = array_values(array_filter($photo_temp));

        	// Get next ID for product photos more reliably
        	$statement = $pdo->prepare("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_product_photo'");
			$statement->execute();
			$result = $statement->fetchAll();
			$next_id1 = 1; // Default fallback
			if(!empty($result)) {
				$next_id1 = $result[0]['AUTO_INCREMENT'];
			}
			$z = $next_id1;

            $m=0;
            for($i=0;$i<count($photo);$i++)
            {
                $my_ext1 = pathinfo( $photo[$i], PATHINFO_EXTENSION );
		        if( $my_ext1=='jpg' || $my_ext1=='png' || $my_ext1=='jpeg' || $my_ext1=='gif' ) {
		            $final_name1[$m] = $z.'.'.$my_ext1;
                    move_uploaded_file($photo_temp[$i],"../assets/uploads/product_photos/".$final_name1[$m]);
                    $m++;
                    $z++;
		        }
            }

            if(isset($final_name1)) {
            	for($i=0;$i<count($final_name1);$i++)
		        {
		        	$statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo,p_id) VALUES (?,?)");
		        	$statement->execute(array($final_name1[$i],$_REQUEST['id']));
		        }
            }            
        }

        if($path == '') {
        	// No new image uploaded - only update other fields
        	$statement = $pdo->prepare("UPDATE tbl_product SET 
        							p_name=?, 
        							p_old_price=?, 
        							p_current_price=?, 
        							p_qty=?,
        							p_description=?,
        							p_short_description=?,
        							p_feature=?,
        							p_condition=?,
        							p_return_policy=?,
        							p_is_featured=?,
        							p_is_active=?,
        							ecat_id=?

        							WHERE p_id=?");
        	$statement->execute(array(
        							$_POST['p_name'],
        							$_POST['p_old_price'],
        							$_POST['p_current_price'],
        							$_POST['p_qty'],
        							$_POST['p_description'],
        							$_POST['p_short_description'],
        							$_POST['p_feature'],
        							$_POST['p_condition'],
        							$_POST['p_return_policy'],
        							$_POST['p_is_featured'],
        							$_POST['p_is_active'],
        							$_POST['ecat_id'],
        							$_REQUEST['id']
        						));
        } else {
        	// New image uploaded - handle image update safely
        	// First, get the current image name to safely delete it
        	$statement = $pdo->prepare("SELECT p_featured_photo FROM tbl_product WHERE p_id=?");
        	$statement->execute(array($_REQUEST['id']));
        	$current_image_result = $statement->fetchAll(PDO::FETCH_ASSOC);
        	$current_image = '';
        	foreach($current_image_result as $row) {
        		$current_image = $row['p_featured_photo'];
        	}
        	
        	// Delete the old image file if it exists and is different from the new one
        	if($current_image != '' && file_exists('../assets/uploads/'.$current_image)) {
        		unlink('../assets/uploads/'.$current_image);
        	}

        	// Generate unique image name with timestamp to prevent conflicts
        	$timestamp = time();
			$final_name = 'product-featured-'.$_REQUEST['id'].'-'.$timestamp.'.'.$ext;
        	move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );


        	$statement = $pdo->prepare("UPDATE tbl_product SET 
        							p_name=?, 
        							p_old_price=?, 
        							p_current_price=?, 
        							p_qty=?,
        							p_featured_photo=?,
        							p_description=?,
        							p_short_description=?,
        							p_feature=?,
        							p_condition=?,
        							p_return_policy=?,
        							p_is_featured=?,
        							p_is_active=?,
        							ecat_id=?

        							WHERE p_id=?");
        	$statement->execute(array(
        							$_POST['p_name'],
        							$_POST['p_old_price'],
        							$_POST['p_current_price'],
        							$_POST['p_qty'],
        							$final_name,
        							$_POST['p_description'],
        							$_POST['p_short_description'],
        							$_POST['p_feature'],
        							$_POST['p_condition'],
        							$_POST['p_return_policy'],
        							$_POST['p_is_featured'],
        							$_POST['p_is_active'],
        							$_POST['ecat_id'],
        							$_REQUEST['id']
        						));
        }
		

        if(isset($_POST['size'])) {

        	$statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
        	$statement->execute(array($_REQUEST['id']));

			foreach($_POST['size'] as $value) {
				$statement = $pdo->prepare("INSERT INTO tbl_product_size (size_id,p_id) VALUES (?,?)");
				$statement->execute(array($value,$_REQUEST['id']));
			}
		} else {
			$statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
        	$statement->execute(array($_REQUEST['id']));
		}

		if(isset($_POST['color'])) {
			
			$statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
        	$statement->execute(array($_REQUEST['id']));

			foreach($_POST['color'] as $value) {
				$statement = $pdo->prepare("INSERT INTO tbl_product_color (color_id,p_id) VALUES (?,?)");
				$statement->execute(array($value,$_REQUEST['id']));
			}
		} else {
			$statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
        	$statement->execute(array($_REQUEST['id']));
		}
	
    	$success_message = 'Product is updated successfully.';
    }
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<style>
.modern-page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.modern-page-header h1 {
    margin: 0;
    font-size: 2.5rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 15px;
}

.modern-page-header .subtitle {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 1.1rem;
}

.modern-form-container {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #e3e6f0;
    margin-bottom: 2rem;
}

.modern-form-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #e3e6f0;
}

.modern-form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.section-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.modern-form-group {
    margin-bottom: 1.5rem;
}

.modern-form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.95rem;
}

.modern-form-label .required {
    color: #e74c3c;
    margin-left: 3px;
}

.modern-form-input, .modern-form-select, .modern-form-textarea {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.modern-form-input:focus, .modern-form-select:focus, .modern-form-textarea:focus {
    outline: none;
    border-color: #667eea;
    background-color: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.modern-file-input {
    width: 100%;
    padding: 12px 15px;
    border: 2px dashed #e3e6f0;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
    cursor: pointer;
}

.modern-file-input:hover {
    border-color: #667eea;
    background-color: rgba(102, 126, 234, 0.05);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.form-row-triple {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 1.5rem;
}

.modern-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.modern-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    color: white;
}

.modern-btn-secondary {
    background: #6c757d;
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    margin-left: 10px;
}

.modern-btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-1px);
    color: white;
}

.modern-alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    border: none;
    font-weight: 500;
}

.modern-alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border-left: 4px solid #28a745;
}

.modern-alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f1b0b7 100%);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

@media (max-width: 768px) {
    .modern-page-header {
        padding: 1.5rem;
        text-align: center;
    }
    
    .modern-page-header h1 {
        font-size: 2rem;
        justify-content: center;
    }
    
    .modern-form-container {
        padding: 1.5rem;
        margin: 0 1rem;
    }
    
    .form-row, .form-row-triple {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-edit"></i>
        Edit Product
    </h1>
    <p class="subtitle">Update product information, pricing, and attributes</p>
    <div style="margin-top: 1rem;">
        <a href="product.php" class="modern-btn-secondary">
            <i class="fa fa-list"></i>
            View All Products
        </a>
    </div>
</div>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$p_name = $row['p_name'];
	$p_old_price = $row['p_old_price'];
	$p_current_price = $row['p_current_price'];
	$p_qty = $row['p_qty'];
	$p_featured_photo = $row['p_featured_photo'];
	$p_description = $row['p_description'];
	$p_short_description = $row['p_short_description'];
	$p_feature = $row['p_feature'];
	$p_condition = $row['p_condition'];
	$p_return_policy = $row['p_return_policy'];
	$p_is_featured = $row['p_is_featured'];
	$p_is_active = $row['p_is_active'];
	$ecat_id = $row['ecat_id'];
}

$statement = $pdo->prepare("SELECT * 
                        FROM tbl_end_category t1
                        JOIN tbl_mid_category t2
                        ON t1.mcat_id = t2.mcat_id
                        JOIN tbl_top_category t3
                        ON t2.tcat_id = t3.tcat_id
                        WHERE t1.ecat_id=?");
$statement->execute(array($ecat_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$ecat_name = $row['ecat_name'];
    $mcat_id = $row['mcat_id'];
    $tcat_id = $row['tcat_id'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_product_size WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$size_id[] = $row['size_id'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_product_color WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$color_id[] = $row['color_id'];
}
?>


<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if($error_message): ?>
            <div class="modern-alert modern-alert-danger">
                <i class="fa fa-exclamation-triangle"></i>
                <?php echo $error_message; ?>
            </div>
            <?php endif; ?>

            <?php if($success_message): ?>
            <div class="modern-alert modern-alert-success">
                <i class="fa fa-check-circle"></i>
                <?php echo $success_message; ?>
            </div>
            <?php endif; ?>

            <div class="modern-form-container">
                <form action="" method="post" enctype="multipart/form-data">
                    
                    <!-- Category Selection Section -->
                    <div class="modern-form-section">
                        <div class="section-title">
                            <i class="fa fa-sitemap"></i>
                            Category Assignment
                        </div>
                        
                        <div class="form-row-triple">
                            <div class="modern-form-group">
                                <label class="modern-form-label">
                                    <i class="fa fa-folder"></i>
                                    Top Category
                                    <span class="required">*</span>
                                </label>
                                <select name="tcat_id" class="modern-form-select top-cat" required>
                                    <option value="">Select Top Level Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);   
                                    foreach ($result as $row) {
                                        ?>
                                        <option value="<?php echo $row['tcat_id']; ?>" <?php if($row['tcat_id'] == $tcat_id){echo 'selected';} ?>><?php echo htmlspecialchars($row['tcat_name']); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="modern-form-group">
                                <label class="modern-form-label">
                                    <i class="fa fa-sitemap"></i>
                                    Mid Category
                                    <span class="required">*</span>
                                </label>
                                <select name="mcat_id" class="modern-form-select mid-cat" required>
                                    <option value="">Select Mid Level Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id = ? ORDER BY mcat_name ASC");
                                    $statement->execute(array($tcat_id));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);   
                                    foreach ($result as $row) {
                                        ?>
                                        <option value="<?php echo $row['mcat_id']; ?>" <?php if($row['mcat_id'] == $mcat_id){echo 'selected';} ?>><?php echo htmlspecialchars($row['mcat_name']); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="modern-form-group">
                                <label class="modern-form-label">
                                    <i class="fa fa-tag"></i>
                                    End Category
                                    <span class="required">*</span>
                                </label>
                                <select name="ecat_id" class="modern-form-select end-cat" required>
                                    <option value="">Select End Level Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id = ? ORDER BY ecat_name ASC");
                                    $statement->execute(array($mcat_id));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);   
                                    foreach ($result as $row) {
                                        ?>
                                        <option value="<?php echo $row['ecat_id']; ?>" <?php if($row['ecat_id'] == $ecat_id){echo 'selected';} ?>><?php echo htmlspecialchars($row['ecat_name']); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Product Information -->
                    <div class="modern-form-section">
                        <div class="section-title">
                            <i class="fa fa-info-circle"></i>
                            Basic Information
                        </div>
                        
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fa fa-cube"></i>
                                Product Name
                                <span class="required">*</span>
                            </label>
                            <input type="text" name="p_name" class="modern-form-input" value="<?php echo htmlspecialchars($p_name); ?>" placeholder="Enter product name" required>
                        </div>
                        
                        <div class="form-row-triple">
                            <div class="modern-form-group">
                                <label class="modern-form-label">
                                    <i class="fa fa-tag"></i>
                                    Old Price (INR)
                                </label>
                                <input type="number" name="p_old_price" class="modern-form-input" value="<?php echo htmlspecialchars($p_old_price); ?>" placeholder="0.00" step="0.01" min="0">
                            </div>
                            
                            <div class="modern-form-group">
                                <label class="modern-form-label">
                                    <i class="fa fa-money"></i>
                                    Current Price (INR)
                                    <span class="required">*</span>
                                </label>
                                <input type="number" name="p_current_price" class="modern-form-input" value="<?php echo htmlspecialchars($p_current_price); ?>" placeholder="0.00" step="0.01" min="0" required>
                            </div>
                            
                            <div class="modern-form-group">
                                <label class="modern-form-label">
                                    <i class="fa fa-cubes"></i>
                                    Quantity
                                    <span class="required">*</span>
                                </label>
                                <input type="number" name="p_qty" class="modern-form-input" value="<?php echo htmlspecialchars($p_qty); ?>" placeholder="0" min="0" required>
                            </div>
                        </div>
                    </div>
                    <!-- Product Attributes -->
                    <div class="modern-form-section">
                        <div class="section-title">
                            <i class="fa fa-cogs"></i>
                            Product Attributes
                        </div>
                        
                        <div class="form-row">
                            <div class="modern-form-group">
                                <label class="modern-form-label">
                                    <i class="fa fa-expand"></i>
                                    Available Sizes
                                </label>
                                <select name="size[]" class="modern-form-select" multiple="multiple" style="height: 120px;">
                                    <?php
                                    $is_select = '';
                                    $statement = $pdo->prepare("SELECT * FROM tbl_size ORDER BY size_id ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);			
                                    foreach ($result as $row) {
                                        if(isset($size_id)) {
                                            if(in_array($row['size_id'],$size_id)) {
                                                $is_select = 'selected';
                                            } else {
                                                $is_select = '';
                                            }
                                        }
                                        ?>
                                        <option value="<?php echo $row['size_id']; ?>" <?php echo $is_select; ?>><?php echo htmlspecialchars($row['size_name']); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <small class="text-muted">Hold Ctrl/Cmd to select multiple sizes</small>
                            </div>
                            
                            <div class="modern-form-group">
                                <label class="modern-form-label">
                                    <i class="fa fa-paint-brush"></i>
                                    Available Colors
                                </label>
                                <select name="color[]" class="modern-form-select" multiple="multiple" style="height: 120px;">
                                    <?php
                                    $is_select = '';
                                    $statement = $pdo->prepare("SELECT * FROM tbl_color ORDER BY color_id ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);			
                                    foreach ($result as $row) {
                                        if(isset($color_id)) {
                                            if(in_array($row['color_id'],$color_id)) {
                                                $is_select = 'selected';
                                            } else {
                                                $is_select = '';
                                            }
                                        }
                                        ?>
                                        <option value="<?php echo $row['color_id']; ?>" <?php echo $is_select; ?>><?php echo htmlspecialchars($row['color_name']); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <small class="text-muted">Hold Ctrl/Cmd to select multiple colors</small>
                            </div>
                        </div>
                    </div>

                    <!-- Product Images -->
                    <div class="modern-form-section">
                        <div class="section-title">
                            <i class="fa fa-camera"></i>
                            Product Images
                        </div>
                        
                        <div class="form-row">
                            <div class="modern-form-group">
                                <label class="modern-form-label">
                                    <i class="fa fa-image"></i>
                                    Current Featured Photo
                                </label>
                                <div style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #f8f9fa; border-radius: 8px; border: 1px solid #e3e6f0;">
                                    <img src="../assets/uploads/<?php echo htmlspecialchars($p_featured_photo); ?>" alt="Featured Photo" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 2px solid #e3e6f0;">
                                    <div>
                                        <h4 style="margin: 0 0 0.5rem 0; color: #2c3e50; font-size: 1.1rem;">Current Image</h4>
                                        <p style="margin: 0; color: #6c757d; font-size: 0.9rem;">Filename: <?php echo htmlspecialchars($p_featured_photo); ?></p>
                                        <p style="margin: 0; color: #6c757d; font-size: 0.9rem;">Upload a new image below to replace this one</p>
                                    </div>
                                </div>
                                <input type="hidden" name="current_photo" value="<?php echo htmlspecialchars($p_featured_photo); ?>">
                            </div>
                            
                            <div class="modern-form-group">
                                <label class="modern-form-label">
                                    <i class="fa fa-upload"></i>
                                    Change Featured Photo
                                </label>
                                <input type="file" name="p_featured_photo" class="modern-file-input" accept=".jpg,.jpeg,.png,.gif">
                                <small class="text-muted">Only JPG, JPEG, PNG and GIF files are allowed</small>
                            </div>
                        </div>
                    </div>
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fa fa-images"></i>
                                Additional Product Photos
                            </label>
                            <div style="background: #f8f9fa; border-radius: 8px; padding: 15px; border: 1px solid #e3e6f0;">
                                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px; margin-bottom: 15px;">
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
                                    $statement->execute(array($_REQUEST['id']));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        ?>
                                        <div style="position: relative; border-radius: 8px; overflow: hidden;">
                                            <img src="../assets/uploads/product_photos/<?php echo htmlspecialchars($row['photo']); ?>" alt="" style="width: 100%; height: 120px; object-fit: cover;">
                                            <a onclick="return confirmDelete();" href="product-other-photo-delete.php?id=<?php echo $row['pp_id']; ?>&id1=<?php echo $_REQUEST['id']; ?>" style="position: absolute; top: 5px; right: 5px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 12px;">×</a>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <button type="button" id="btnAddNew" class="modern-btn-secondary" style="margin: 0;">
                                    <i class="fa fa-plus"></i>
                                    Add More Photos
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Descriptions -->
                    <div class="modern-form-section">
                        <div class="section-title">
                            <i class="fa fa-file-text"></i>
                            Product Descriptions
                        </div>
                        
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fa fa-align-left"></i>
                                Product Description
                            </label>
                            <textarea name="p_description" class="modern-form-textarea" rows="8" id="editor1" placeholder="Enter detailed product description..."><?php echo htmlspecialchars($p_description); ?></textarea>
                        </div>
                        
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fa fa-list"></i>
                                Short Description
                            </label>
                            <textarea name="p_short_description" class="modern-form-textarea" rows="4" id="editor2" placeholder="Enter brief product summary..."><?php echo htmlspecialchars($p_short_description); ?></textarea>
                        </div>
                        
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fa fa-star"></i>
                                Product Features
                            </label>
                            <textarea name="p_feature" class="modern-form-textarea" rows="6" id="editor3" placeholder="List key product features..."><?php echo htmlspecialchars($p_feature); ?></textarea>
                        </div>
                        
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fa fa-info"></i>
                                Conditions & Terms
                            </label>
                            <textarea name="p_condition" class="modern-form-textarea" rows="4" id="editor4" placeholder="Enter product conditions..."><?php echo htmlspecialchars($p_condition); ?></textarea>
                        </div>
                        
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fa fa-undo"></i>
                                Return Policy
                            </label>
                            <textarea name="p_return_policy" class="modern-form-textarea" rows="4" id="editor5" placeholder="Enter return policy details..."><?php echo htmlspecialchars($p_return_policy); ?></textarea>
                        </div>
                    </div>

                    <!-- Product Settings -->
                    <div class="modern-form-section">
                        <div class="section-title">
                            <i class="fa fa-cog"></i>
                            Product Settings
                        </div>
                        
                        <div class="form-row">
                            <div class="modern-form-group">
                                <label class="modern-form-label">
                                    <i class="fa fa-star-o"></i>
                                    Featured Product
                                </label>
                                <select name="p_is_featured" class="modern-form-select">
                                    <option value="0" <?php if($p_is_featured == '0'){echo 'selected';} ?>>No</option>
                                    <option value="1" <?php if($p_is_featured == '1'){echo 'selected';} ?>>Yes</option>
                                </select>
                            </div>
                            
                            <div class="modern-form-group">
                                <label class="modern-form-label">
                                    <i class="fa fa-toggle-on"></i>
                                    Product Status
                                </label>
                                <select name="p_is_active" class="modern-form-select">
                                    <option value="0" <?php if($p_is_active == '0'){echo 'selected';} ?>>Inactive</option>
                                    <option value="1" <?php if($p_is_active == '1'){echo 'selected';} ?>>Active</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e3e6f0; text-align: center;">
                        <button type="submit" name="form1" class="modern-btn">
                            <i class="fa fa-save"></i>
                            Update Product
                        </button>
                        <a href="product.php" class="modern-btn-secondary">
                            <i class="fa fa-times"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
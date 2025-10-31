<?php
session_start();
include("admin/inc/config.php");
include("admin/inc/functions.php");
if(!isset($_SESSION['seller'])) {
    header('Location: seller-login.php');
    exit;
}
$seller_id = $_SESSION['seller']['id'];
$error_message = '';
$success_message = '';

if(!isset($_REQUEST['id'])) {
    header('location: seller-products.php');
    exit;
} else {
    // Check the id is valid or not and belongs to this seller
    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=? AND seller_id=?");
    $statement->execute(array($_REQUEST['id'], $seller_id));
    $total = $statement->rowCount();
    if( $total == 0 ) {
        header('location: seller-products.php');
        exit;
    }
}

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
                    move_uploaded_file($photo_temp[$i],"assets/uploads/product_photos/".$final_name1[$m]);
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
            $statement = $pdo->prepare("UPDATE tbl_product SET 
                                    p_name=?, 
                                    p_old_price=?, 
                                    p_current_price=?, 
                                    p_qty=?,
                                    p_description=?,
                                    p_short_description=?,
                                    p_feature=?,
                                    ecat_id=?
                                    WHERE p_id=? AND seller_id=?");
            $statement->execute(array(
                $_POST['p_name'],
                $_POST['p_old_price'],
                $_POST['p_current_price'],
                $_POST['p_qty'],
                $_POST['p_description'],
                $_POST['p_short_description'],
                $_POST['p_feature'],
                $_POST['ecat_id'],
                $_REQUEST['id'],
                $seller_id
            ));
        } else {
            // Getting photo ID to unlink from folder
            $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=? AND seller_id=?");
            $statement->execute(array($_REQUEST['id'], $seller_id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
            foreach ($result as $row) {
                $p_featured_photo = $row['p_featured_photo'];
                if(file_exists('assets/uploads/'.$p_featured_photo)) {
                    unlink('assets/uploads/'.$p_featured_photo);
                }
            }

            // Generate unique image name with timestamp to prevent conflicts
            $timestamp = time();
            $final_name = 'product-featured-'.$_REQUEST['id'].'-'.$timestamp.'.'.$ext;
            move_uploaded_file( $path_tmp, 'assets/uploads/'.$final_name );

            $statement = $pdo->prepare("UPDATE tbl_product SET 
                                    p_name=?, 
                                    p_old_price=?, 
                                    p_current_price=?, 
                                    p_qty=?,
                                    p_description=?,
                                    p_short_description=?,
                                    p_feature=?,
                                    p_featured_photo=?,
                                    ecat_id=?
                                    WHERE p_id=? AND seller_id=?");
            $statement->execute(array(
                $_POST['p_name'],
                $_POST['p_old_price'],
                $_POST['p_current_price'],
                $_POST['p_qty'],
                $_POST['p_description'],
                $_POST['p_short_description'],
                $_POST['p_feature'],
                $final_name,
                $_POST['ecat_id'],
                $_REQUEST['id'],
                $seller_id
            ));
        }

        // Update size and color associations
        // First delete existing associations
        $statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
        $statement->execute(array($_REQUEST['id']));
        
        $statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
        $statement->execute(array($_REQUEST['id']));

        // Insert new size associations
        if(isset($_POST['size'])) {
            foreach($_POST['size'] as $size_id) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_size (p_id,size_id) VALUES (?,?)");
                $statement->execute(array($_REQUEST['id'],$size_id));
            }
        }

        // Insert new color associations
        if(isset($_POST['color'])) {
            foreach($_POST['color'] as $color_id) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_color (p_id,color_id) VALUES (?,?)");
                $statement->execute(array($_REQUEST['id'],$color_id));
            }
        }

        $success_message = 'Product is updated successfully!';
    }
}

$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=? AND seller_id=?");
$statement->execute(array($_REQUEST['id'], $seller_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            

// Initialize all variables with default values
$p_name = '';
$p_old_price = '';
$p_current_price = '';
$p_qty = '';
$p_description = '';
$p_short_description = '';
$p_feature = '';
$p_condition = '';
$p_return_policy = '';
$p_featured_photo = '';
$tcat_id = '';
$mcat_id = '';
$ecat_id = '';

if (!empty($result)) {
    foreach ($result as $row) {
        $p_name = isset($row['p_name']) ? $row['p_name'] : '';
        $p_old_price = isset($row['p_old_price']) ? $row['p_old_price'] : '';
        $p_current_price = isset($row['p_current_price']) ? $row['p_current_price'] : '';
        $p_qty = isset($row['p_qty']) ? $row['p_qty'] : '';
        $p_description = isset($row['p_description']) ? $row['p_description'] : '';
        $p_short_description = isset($row['p_short_description']) ? $row['p_short_description'] : '';
        $p_feature = isset($row['p_feature']) ? $row['p_feature'] : '';
        $p_condition = isset($row['p_condition']) ? $row['p_condition'] : '';
        $p_return_policy = isset($row['p_return_policy']) ? $row['p_return_policy'] : '';
        $p_featured_photo = isset($row['p_featured_photo']) ? $row['p_featured_photo'] : '';
        $tcat_id = isset($row['tcat_id']) ? $row['tcat_id'] : '';
        $mcat_id = isset($row['mcat_id']) ? $row['mcat_id'] : '';
        $ecat_id = isset($row['ecat_id']) ? $row['ecat_id'] : '';
    }
}

// Get current size and color selections
$statement = $pdo->prepare("SELECT size_id FROM tbl_product_size WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$current_sizes = $statement->fetchAll(PDO::FETCH_COLUMN);

$statement = $pdo->prepare("SELECT color_id FROM tbl_product_color WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$current_colors = $statement->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Seller Panel - Edit Product</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    
    <link rel="stylesheet" href="admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin/css/ionicons.min.css">
    <link rel="stylesheet" href="admin/css/AdminLTE.min.css">
    <link rel="stylesheet" href="admin/css/_all-skins.min.css">
    <link rel="stylesheet" href="admin/css/select2.min.css">
    <link rel="stylesheet" href="admin/css/summernote.css">
    <link rel="stylesheet" href="assets/css/seller-modern.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<?php include('seller-header.php'); ?>
<div class="wrapper">
<?php include('seller-sidebar.php'); ?>
    <div class="content-wrapper" style="min-height:100vh;">
        <!-- Page Header -->
        <div class="seller-page-header fade-in" style="margin-top: 20px;">
            <h1 class="seller-page-title">
                <i class="fa fa-edit"></i>
                Edit Product
            </h1>
            <p class="seller-page-subtitle">Update and modify your product information</p>
        </div>

        <section class="content">
            <!-- Alert Messages -->
            <?php if($error_message): ?>
                <div class="seller-alert alert-danger fade-in">
                    <i class="fa fa-exclamation-circle"></i>
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <?php if($success_message): ?>
                <div class="seller-alert alert-success fade-in">
                    <i class="fa fa-check-circle"></i>
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <form action="" method="post" enctype="multipart/form-data" class="seller-product-form slide-in">
                <div class="seller-form-container">
                    <div class="form-section">
                        <div class="section-header">
                            <h3><i class="fa fa-info-circle"></i> Basic Information</h3>
                            <p>Essential product details and categorization</p>
                        </div>
                        <div class="form-content">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="seller-label">
                                        <i class="fa fa-sitemap"></i>
                                        Top Level Category <span class="required">*</span>
                                    </label>
                                    <select name="tcat_id" class="seller-form-control select2 top-cat" required>
                                        <option value="">Select Top Level Category</option>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            ?>
                                            <option value="<?php echo $row['tcat_id']; ?>" <?php if($row['tcat_id'] == $tcat_id){echo 'selected';} ?>><?php echo $row['tcat_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="seller-label">
                                        <i class="fa fa-tags"></i>
                                        Mid Level Category <span class="required">*</span>
                                    </label>
                                    <select name="mcat_id" class="seller-form-control select2 mid-cat" required>
                                        <option value="">Select Mid Level Category</option>
                                        <?php
                                        if($tcat_id) {
                                            $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=? ORDER BY mcat_name ASC");
                                            $statement->execute(array($tcat_id));
                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result as $row) {
                                                ?>
                                                <option value="<?php echo $row['mcat_id']; ?>" <?php if($row['mcat_id'] == $mcat_id){echo 'selected';} ?>><?php echo $row['mcat_name']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="seller-label">
                                        <i class="fa fa-tag"></i>
                                        End Level Category <span class="required">*</span>
                                    </label>
                                    <select name="ecat_id" class="seller-form-control select2 end-cat" required>
                                        <option value="">Select End Level Category</option>
                                        <?php
                                        if($mcat_id) {
                                            $statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=? ORDER BY ecat_name ASC");
                                            $statement->execute(array($mcat_id));
                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result as $row) {
                                                ?>
                                                <option value="<?php echo $row['ecat_id']; ?>" <?php if($row['ecat_id'] == $ecat_id){echo 'selected';} ?>><?php echo $row['ecat_name']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="seller-label">
                                        <i class="fa fa-cube"></i>
                                        Product Name <span class="required">*</span>
                                    </label>
                                    <input type="text" name="p_name" class="seller-form-control" 
                                           placeholder="Enter product name" value="<?php echo htmlspecialchars($p_name); ?>" required>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="seller-label">
                                        <i class="fa fa-rupee"></i>
                                        Old Price (INR)
                                    </label>
                                    <input type="number" name="p_old_price" class="seller-form-control" 
                                           placeholder="0.00" step="0.01" min="0" value="<?php echo $p_old_price; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="seller-label">
                                        <i class="fa fa-rupee"></i>
                                        Current Price (INR) <span class="required">*</span>
                                    </label>
                                    <input type="number" name="p_current_price" class="seller-form-control" 
                                           placeholder="0.00" step="0.01" min="0.01" value="<?php echo $p_current_price; ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="seller-label">
                                        <i class="fa fa-cubes"></i>
                                        Quantity <span class="required">*</span>
                                    </label>
                                    <input type="number" name="p_qty" class="seller-form-control" 
                                           placeholder="0" min="0" value="<?php echo $p_qty; ?>" required>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="seller-label">
                                        <i class="fa fa-expand-arrows-alt"></i>
                                        Available Sizes
                                    </label>
                                    <select name="size[]" class="seller-form-control select2" multiple="multiple">
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_size ORDER BY size_id ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            ?>
                                            <option value="<?php echo $row['size_id']; ?>" <?php if(in_array($row['size_id'], $current_sizes)){echo 'selected';} ?>><?php echo $row['size_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <small class="form-help">Select multiple sizes (optional)</small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="seller-label">
                                        <i class="fa fa-palette"></i>
                                        Available Colors
                                    </label>
                                    <select name="color[]" class="seller-form-control select2" multiple="multiple">
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_color ORDER BY color_id ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            ?>
                                            <option value="<?php echo $row['color_id']; ?>" <?php if(in_array($row['color_id'], $current_colors)){echo 'selected';} ?>><?php echo $row['color_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <small class="form-help">Select multiple colors (optional)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Images Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <h3><i class="fa fa-images"></i> Product Images</h3>
                            <p>Upload high-quality images to showcase your product</p>
                        </div>
                        <div class="form-content">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="seller-label">
                                        <i class="fa fa-camera"></i>
                                        Featured Photo
                                    </label>
                                    <?php if($p_featured_photo): ?>
                                        <div class="current-image">
                                            <img src="assets/uploads/<?php echo $p_featured_photo; ?>" alt="Current Featured Photo" style="max-width: 200px; margin-bottom: 10px;">
                                            <p><small>Current featured photo</small></p>
                                        </div>
                                    <?php endif; ?>
                                    <div class="seller-file-upload">
                                        <input type="file" name="p_featured_photo" accept=".jpg,.jpeg,.png,.gif">
                                        <div class="file-upload-text">
                                            <i class="fa fa-upload"></i>
                                            <span><?php echo $p_featured_photo ? 'Change main product image' : 'Choose main product image'; ?></span>
                                        </div>
                                    </div>
                                    <small class="form-help">JPG, JPEG, PNG or GIF. Max size 5MB</small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="seller-label">
                                        <i class="fa fa-images"></i>
                                        Additional Photos
                                    </label>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
                                    $statement->execute(array($_REQUEST['id']));
                                    $existing_photos = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    if($existing_photos): ?>
                                        <div class="existing-photos" style="margin-bottom: 15px;">
                                            <p><small>Current additional photos:</small></p>
                                            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                                <?php foreach($existing_photos as $photo): ?>
                                                    <div style="position: relative;">
                                                        <img src="assets/uploads/product_photos/<?php echo $photo['photo']; ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                                                        <a href="seller-product-photo-delete.php?id=<?php echo $photo['pp_id']; ?>&p_id=<?php echo $_REQUEST['id']; ?>" 
                                                           style="position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 12px;"
                                                           onclick="return confirm('Delete this photo?');">×</a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="seller-multi-upload">
                                        <table id="ProductTable" class="upload-table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="seller-file-upload">
                                                            <input type="file" name="photo[]" accept=".jpg,.jpeg,.png,.gif">
                                                            <div class="file-upload-text">
                                                                <i class="fa fa-plus"></i>
                                                                <span>Add image</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="action-col">
                                                        <button type="button" class="Delete seller-btn-danger"><i class="fa fa-times"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" id="btnAddNew" class="seller-modern-btn seller-modern-btn-primary seller-modern-btn-sm">
                                            <i class="fa fa-plus"></i> Add More Images
                                        </button>
                                    </div>
                                    <small class="form-help">Upload multiple product images (optional)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Details Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <h3><i class="fa fa-align-left"></i> Product Details</h3>
                            <p>Detailed information about your product</p>
                        </div>
                        <div class="form-content">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="seller-label">
                                        <i class="fa fa-align-left"></i>
                                        Product Description
                                    </label>
                                    <textarea name="p_description" class="seller-form-control" id="editor1" placeholder="Enter detailed product description"><?php echo $p_description; ?></textarea>
                                    <small class="form-help">Detailed description of your product (optional)</small>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="seller-label">
                                        <i class="fa fa-list-ul"></i>
                                        Short Description
                                    </label>
                                    <textarea name="p_short_description" class="seller-form-control" id="editor2" placeholder="Enter brief product summary"><?php echo $p_short_description; ?></textarea>
                                    <small class="form-help">Brief summary for product listings (optional)</small>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="seller-label">
                                        <i class="fa fa-star"></i>
                                        Product Features
                                    </label>
                                    <textarea name="p_feature" class="seller-form-control" id="editor3" placeholder="List key product features"><?php echo $p_feature; ?></textarea>
                                    <small class="form-help">Key features and specifications (optional)</small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="seller-label">
                                        <i class="fa fa-info-circle"></i>
                                        Product Condition
                                    </label>
                                    <textarea name="p_condition" class="seller-form-control" id="editor4" placeholder="Describe product condition"><?php echo $p_condition; ?></textarea>
                                    <small class="form-help">Product condition details (optional)</small>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="seller-label">
                                        <i class="fa fa-undo"></i>
                                        Return Policy
                                    </label>
                                    <textarea name="p_return_policy" class="seller-form-control" id="editor5" placeholder="Define your return policy"><?php echo $p_return_policy; ?></textarea>
                                    <small class="form-help">Return and exchange policy (optional)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Section -->
                    <div class="form-section">
                        <div class="form-actions">
                            <button type="submit" name="form1" class="seller-modern-btn seller-modern-btn-primary seller-modern-btn-lg">
                                <i class="fa fa-save"></i> Update Product
                            </button>
                            <a href="seller-products.php" class="seller-modern-btn seller-modern-btn-secondary seller-modern-btn-lg">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>

<script src="admin/js/jquery-2.2.3.min.js"></script>
<script src="admin/js/bootstrap.min.js"></script>
<script src="admin/js/app.min.js"></script>
<script src="admin/js/select2.full.min.js"></script>
<script src="admin/js/summernote.js"></script>
<script>
$(document).ready(function() {
    // Dynamic category dropdowns (AJAX)
    $('.top-cat').on('change', function() {
        var tcat_id = $(this).val();
        $.ajax({
            url: 'admin/get-mid-category.php',
            type: 'POST',
            data: { id: tcat_id },
            success: function(data) {
                $('.mid-cat').html(data).trigger('change');
                $('.end-cat').html('<option value="">Select End Level Category</option>').trigger('change');
            }
        });
    });
    $('.mid-cat').on('change', function() {
        var mcat_id = $(this).val();
        $.ajax({
            url: 'admin/get-end-category.php',
            type: 'POST',
            data: { id: mcat_id },
            success: function(data) {
                $('.end-cat').html(data).trigger('change');
            }
        });
    });
    // Add/Remove multiple photo upload fields
    $('#btnAddNew').on('click', function() {
        var html = '<tr><td><div class="seller-file-upload"><input type="file" name="photo[]" accept=".jpg,.jpeg,.png,.gif"><div class="file-upload-text"><i class="fa fa-plus"></i><span>Add image</span></div></div></td><td class="action-col"><button type="button" class="Delete seller-btn-danger"><i class="fa fa-times"></i></button></td></tr>';
        $('#ProductTable tbody').append(html);
    });
    $(document).on('click', '.Delete', function() {
        $(this).closest('tr').remove();
    });
    $('.select2').select2();
    // Initialize Summernote for all editor fields
    $('#editor1, #editor2, #editor3, #editor4, #editor5').summernote({
        height: 200
    });
});
</script>
</body>
</html>
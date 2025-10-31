<?php
session_start();
include("admin/inc/config.php");
include("admin/inc/functions.php");
include("seller-header.php");
if(!isset($_SESSION['seller'])) {
    header('Location: seller-login.php');
    exit;
}
$seller_id = $_SESSION['seller']['id'];
$error_message = '';
$success_message = '';
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
    } else {
        // Product name: minimum 3 characters
        if(strlen(trim($_POST['p_name'])) < 3){
            $valid = 0;
            $error_message .= 'Product name must be at least 3 characters.<br>';
        }
    }
    if(empty($_POST['p_current_price'])) {
        $valid = 0;
        $error_message .= "Current Price can not be empty<br>";
    } else {
        // Price validation: must be positive number
        if(!is_numeric($_POST['p_current_price']) || $_POST['p_current_price'] <= 0){
            $valid = 0;
            $error_message .= 'Current price must be a positive number.<br>';
        }
    }
    if(empty($_POST['p_qty'])) {
        $valid = 0;
        $error_message .= "Quantity can not be empty<br>";
    } else {
        // Quantity validation: must be positive integer
        if(!is_numeric($_POST['p_qty']) || $_POST['p_qty'] < 0 || $_POST['p_qty'] != intval($_POST['p_qty'])){
            $valid = 0;
            $error_message .= 'Quantity must be a positive whole number.<br>';
        }
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
    } else {
        $valid = 0;
        $error_message .= 'You must have to select a featured photo<br>';
    }
    if($valid == 1) {

    	// Get the next auto-increment ID more reliably
    	$statement = $pdo->prepare("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_product'");
		$statement->execute();
		$result = $statement->fetchAll();
		$ai_id = 1; // Default fallback
		if(!empty($result)) {
			$ai_id = $result[0]['AUTO_INCREMENT'];
		}

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
            for($i=0;$i<count($photo);$i++) {
                $my_ext1 = pathinfo( $photo[$i], PATHINFO_EXTENSION );
                if( $my_ext1=='jpg' || $my_ext1=='png' || $my_ext1=='jpeg' || $my_ext1=='gif' ) {
                    $final_name1[$m] = $z.'.'.$my_ext1;
                    move_uploaded_file($photo_temp[$i],"assets/uploads/product_photos/".$final_name1[$m]);
                    $m++;
                    $z++;
                }
            }
            if(isset($final_name1)) {
                for($i=0;$i<count($final_name1);$i++) {
                    $statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo,p_id) VALUES (?,?)");
                    $statement->execute(array($final_name1[$i],$ai_id));
                }
            }
        }
        // Generate unique image name with timestamp to prevent conflicts
        $timestamp = time();
        $final_name = 'product-featured-'.$ai_id.'-'.$timestamp.'.'.$ext;
        move_uploaded_file( $path_tmp, 'assets/uploads/'.$final_name );
        $statement = $pdo->prepare("INSERT INTO tbl_product(
            p_name,
            p_old_price,
            p_current_price,
            p_qty,
            p_featured_photo,
            p_description,
            p_short_description,
            p_feature,
            p_condition,
            p_return_policy,
            p_total_view,
            p_is_featured,
            p_is_active,
            ecat_id,
            seller_id
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
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
            0,
            0, // p_is_featured always 0 for seller
            0, // p_is_active always 0 for seller
            $_POST['ecat_id'],
            $seller_id
        ));
        if(isset($_POST['size'])) {
            foreach($_POST['size'] as $value) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_size (size_id,p_id) VALUES (?,?)");
                $statement->execute(array($value,$ai_id));
            }
        }
        if(isset($_POST['color'])) {
            foreach($_POST['color'] as $value) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_color (color_id,p_id) VALUES (?,?)");
                $statement->execute(array($value,$ai_id));
            }
        }
        $success_message = 'Product is added successfully and is pending admin approval.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Seller Panel - Add Product</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    
    <!-- CSS Files -->
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
    
    <style>
    .error-msg{color:#e74c3c;font-size:12px;margin-top:6px;display:none;opacity:0;transition:opacity .2s ease}
    .invalid{border-color:#e74c3c !important}
    .error-msg.show{display:block;opacity:1}
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">
<?php include('seller-sidebar.php'); ?>
    <div class="content-wrapper">
        <!-- Page Header -->
        <div class="seller-page-header fade-in" style="margin-top: 20px;">
            <h1 class="seller-page-title">
                <i class="fa fa-plus-circle"></i>
                Add New Product
            </h1>
            <p class="seller-page-subtitle">Create and list a new product in your store</p>
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
                                    <select name="tcat_id" id="tcat_id" class="seller-form-control select2 top-cat">
                                        <option value="">Select Top Level Category</option>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            ?>
                                            <option value="<?php echo $row['tcat_id']; ?>"><?php echo $row['tcat_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="error-msg" id="tcat_id_error"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="seller-label">
                                        <i class="fa fa-tags"></i>
                                        Mid Level Category <span class="required">*</span>
                                    </label>
                                    <select name="mcat_id" id="mcat_id" class="seller-form-control select2 mid-cat">
                                        <option value="">Select Mid Level Category</option>
                                    </select>
                                    <span class="error-msg" id="mcat_id_error"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="seller-label">
                                        <i class="fa fa-tag"></i>
                                        End Level Category <span class="required">*</span>
                                    </label>
                                    <select name="ecat_id" id="ecat_id" class="seller-form-control select2 end-cat">
                                        <option value="">Select End Level Category</option>
                                    </select>
                                    <span class="error-msg" id="ecat_id_error"></span>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="seller-label">
                                        <i class="fa fa-cube"></i>
                                        Product Name <span class="required">*</span>
                                    </label>
                                    <input type="text" name="p_name" id="p_name" class="seller-form-control" 
                                           placeholder="Enter product name">
                                    <span class="error-msg" id="p_name_error"></span>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="seller-label">
                                        <i class="fa fa-rupee"></i>
                                        Old Price (INR)
                                    </label>
                                    <input type="number" name="p_old_price" id="p_old_price" class="seller-form-control" 
                                           placeholder="0.00" step="0.01" min="0">
                                    <span class="error-msg" id="p_old_price_error"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="seller-label">
                                        <i class="fa fa-rupee"></i>
                                        Current Price (INR) <span class="required">*</span>
                                    </label>
                                    <input type="number" name="p_current_price" id="p_current_price" class="seller-form-control" 
                                           placeholder="0.00" step="0.01" min="0.01">
                                    <span class="error-msg" id="p_current_price_error"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="seller-label">
                                        <i class="fa fa-cubes"></i>
                                        Quantity <span class="required">*</span>
                                    </label>
                                    <input type="number" name="p_qty" id="p_qty" class="seller-form-control" 
                                           placeholder="0" min="0">
                                    <span class="error-msg" id="p_qty_error"></span>
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
                                            <option value="<?php echo $row['size_id']; ?>"><?php echo $row['size_name']; ?></option>
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
                                            <option value="<?php echo $row['color_id']; ?>"><?php echo $row['color_name']; ?></option>
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
                                        Featured Photo <span class="required">*</span>
                                    </label>
                                    <div class="seller-file-upload">
                                        <input type="file" name="p_featured_photo" id="p_featured_photo" accept=".jpg,.jpeg,.png,.gif">
                                        <span class="error-msg" id="p_featured_photo_error"></span>
                                        <div class="file-upload-text">
                                            <i class="fa fa-upload"></i>
                                            <span>Choose main product image</span>
                                        </div>
                                    </div>
                                    <small class="form-help">JPG, JPEG, PNG or GIF. Max size 5MB</small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="seller-label">
                                        <i class="fa fa-images"></i>
                                        Additional Photos
                                    </label>
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
                                    <textarea name="p_description" class="seller-form-control" id="editor1" placeholder="Enter detailed product description"></textarea>
                                    <small class="form-help">Detailed description of your product (optional)</small>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="seller-label">
                                        <i class="fa fa-list-ul"></i>
                                        Short Description
                                    </label>
                                    <textarea name="p_short_description" class="seller-form-control" id="editor2" placeholder="Enter brief product summary"></textarea>
                                    <small class="form-help">Brief summary for product listings (optional)</small>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="seller-label">
                                        <i class="fa fa-star"></i>
                                        Product Features
                                    </label>
                                    <textarea name="p_feature" class="seller-form-control" id="editor3" placeholder="List key product features"></textarea>
                                    <small class="form-help">Key features and specifications (optional)</small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="seller-label">
                                        <i class="fa fa-info-circle"></i>
                                        Product Condition
                                    </label>
                                    <textarea name="p_condition" class="seller-form-control" id="editor4" placeholder="Describe product condition"></textarea>
                                    <small class="form-help">Product condition details (optional)</small>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="seller-label">
                                        <i class="fa fa-undo"></i>
                                        Return Policy
                                    </label>
                                    <textarea name="p_return_policy" class="seller-form-control" id="editor5" placeholder="Define your return policy"></textarea>
                                    <small class="form-help">Return and exchange policy (optional)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Section -->
                    <div class="form-section">
                        <div class="form-content text-center">
                            <div class="form-actions">
                                <button type="submit" name="form1" class="seller-modern-btn seller-modern-btn-success seller-btn-lg">
                                    <i class="fa fa-plus-circle"></i>
                                    Add Product
                                </button>
                                <a href="seller-products.php" class="seller-modern-btn seller-modern-btn-secondary seller-btn-lg">
                                    <i class="fa fa-times"></i>
                                    Cancel
                                </a>
                            </div>
                            <p class="form-note">
                                <i class="fa fa-info-circle"></i>
                                Your product will be pending admin approval after submission
                            </p>
                        </div>
                    </div>
                </div>
            </form>
                </div>
            </div>
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
    // Add animations
    setTimeout(function() {
        $('.fade-in').addClass('visible');
        $('.slide-in').addClass('visible');
    }, 100);
    
    // Initialize Select2 with custom styling
    $('.select2').select2({
        theme: 'bootstrap',
        placeholder: 'Select option...',
        allowClear: true,
        width: '100%'
    });
    
    // Dynamic category dropdowns (AJAX)
    $('.top-cat').on('change', function() {
        var tcat_id = $(this).val();
        if(tcat_id) {
            $.ajax({
                url: 'admin/get-mid-category.php',
                type: 'POST',
                data: { id: tcat_id },
                beforeSend: function() {
                    $('.mid-cat').prop('disabled', true).html('<option value="">Loading...</option>');
                    $('.end-cat').prop('disabled', true).html('<option value="">Select End Level Category</option>');
                },
                success: function(data) {
                    $('.mid-cat').prop('disabled', false).html(data).trigger('change');
                },
                error: function() {
                    $('.mid-cat').prop('disabled', false).html('<option value="">Error loading categories</option>');
                }
            });
        } else {
            $('.mid-cat').html('<option value="">Select Mid Level Category</option>').trigger('change');
            $('.end-cat').html('<option value="">Select End Level Category</option>').trigger('change');
        }
    });
    
    $('.mid-cat').on('change', function() {
        var mcat_id = $(this).val();
        if(mcat_id) {
            $.ajax({
                url: 'admin/get-end-category.php',
                type: 'POST',
                data: { id: mcat_id },
                beforeSend: function() {
                    $('.end-cat').prop('disabled', true).html('<option value="">Loading...</option>');
                },
                success: function(data) {
                    $('.end-cat').prop('disabled', false).html(data).trigger('change');
                },
                error: function() {
                    $('.end-cat').prop('disabled', false).html('<option value="">Error loading categories</option>');
                }
            });
        } else {
            $('.end-cat').html('<option value="">Select End Level Category</option>').trigger('change');
        }
    });
    
    // Enhanced file upload functionality
    $('#btnAddNew').on('click', function() {
        var html = `
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
        `;
        $('#ProductTable tbody').append(html);
        
        // Animate new row
        $('#ProductTable tbody tr:last-child').hide().fadeIn(300);
    });
    
    $(document).on('click', '.Delete', function() {
        $(this).closest('tr').fadeOut(300, function() {
            $(this).remove();
        });
    });
    
    // Initialize Summernote with custom configuration
    $('#editor1, #editor2, #editor3, #editor4, #editor5').summernote({
        height: 200,
        placeholder: 'Type here...',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
    
    // Form validation enhancement
    $('form').on('submit', function(e) {
        var isValid = true;
        var errorMessages = [];
        
        // Check required fields
        $('[required]').each(function() {
            if(!$(this).val()) {
                isValid = false;
                $(this).addClass('error');
                var label = $(this).closest('.form-group').find('label').text().replace('*', '').trim();
                errorMessages.push(label + ' is required');
            } else {
                $(this).removeClass('error');
            }
        });
        
        if(!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields:\n' + errorMessages.join('\n'));
            return false;
        }
        
        // Show loading state
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Adding Product...');
    });
    
    // File upload preview
    $(document).on('change', 'input[type="file"]', function() {
        var fileName = $(this)[0].files[0]?.name;
        if(fileName) {
            $(this).siblings('.file-upload-text').find('span').text(fileName);
            $(this).closest('.seller-file-upload').addClass('has-file');
        }
    });
    
    // Price validation
    $('input[name="p_old_price"], input[name="p_current_price"]').on('input', function() {
        var oldPrice = parseFloat($('input[name="p_old_price"]').val()) || 0;
        var currentPrice = parseFloat($('input[name="p_current_price"]').val()) || 0;
        
        if(oldPrice > 0 && currentPrice >= oldPrice) {
            $(this).addClass('warning');
            $(this).attr('title', 'Current price should be less than old price for discount');
        } else {
            $(this).removeClass('warning');
            $(this).removeAttr('title');
        }
    });
    
    // Product form validation
    (function(){
        function setError(el, msg){
            var err = document.getElementById(el.id + '_error');
            if(err){ err.textContent = msg || ''; err.classList.toggle('show', !!msg); }
            el.classList.toggle('invalid', !!msg);
        }
        function validateProductName(){
            var el = document.getElementById('p_name');
            var ok = el.value.trim().length >= 3;
            return setError(el, ok?'':'Product name must be at least 3 characters.'), ok;
        }
        function validateCurrentPrice(){
            var el = document.getElementById('p_current_price');
            var val = parseFloat(el.value);
            var ok = !isNaN(val) && val > 0;
            return setError(el, ok?'':'Current price must be a positive number.'), ok;
        }
        function validateOldPrice(){
            var el = document.getElementById('p_old_price');
            var val = parseFloat(el.value);
            var ok = el.value === '' || (!isNaN(val) && val >= 0);
            return setError(el, ok?'':'Old price must be a positive number or empty.'), ok;
        }
        function validateQuantity(){
            var el = document.getElementById('p_qty');
            var val = parseInt(el.value);
            var ok = !isNaN(val) && val >= 0 && val === parseFloat(el.value);
            return setError(el, ok?'':'Quantity must be a positive whole number.'), ok;
        }
        function validateFeaturedPhoto(){
            var el = document.getElementById('p_featured_photo');
            var ok = el.files && el.files.length > 0;
            return setError(el, ok?'':'Please select a featured photo.'), ok;
        }
        function validateCategories(){
            var tcat = document.querySelector('select[name="tcat_id"]');
            var mcat = document.querySelector('select[name="mcat_id"]');
            var ecat = document.querySelector('select[name="ecat_id"]');
            
            var tcatValid = tcat && tcat.value !== '';
            var mcatValid = mcat && mcat.value !== '';
            var ecatValid = ecat && ecat.value !== '';
            
            if(!tcatValid) setError(tcat, 'Please select a top level category.');
            else setError(tcat, '');
            
            if(!mcatValid) setError(mcat, 'Please select a mid level category.');
            else setError(mcat, '');
            
            if(!ecatValid) setError(ecat, 'Please select an end level category.');
            else setError(ecat, '');
            
            return tcatValid && mcatValid && ecatValid;
        }
        var form = document.querySelector('form[enctype="multipart/form-data"]');
        if(!form) return;
        
        // Add event listeners for category dropdowns
        var categorySelects = document.querySelectorAll('select[name="tcat_id"], select[name="mcat_id"], select[name="ecat_id"]');
        categorySelects.forEach(function(select){
            select.addEventListener('change', validateCategories);
        });
        
        ['p_name','p_current_price','p_old_price','p_qty','p_featured_photo'].forEach(function(id){
            var el = document.getElementById(id);
            if(!el) return;
            el.addEventListener('input', function(){
                switch(id){
                    case 'p_name': validateProductName(); break;
                    case 'p_current_price': validateCurrentPrice(); break;
                    case 'p_old_price': validateOldPrice(); break;
                    case 'p_qty': validateQuantity(); break;
                    case 'p_featured_photo': validateFeaturedPhoto(); break;
                }
            });
        });
        form.addEventListener('submit', function(e){
            var validations = [
                {fn: validateCategories, field: 'tcat_id'},
                {fn: validateProductName, field: 'p_name'},
                {fn: validateCurrentPrice, field: 'p_current_price'},
                {fn: validateOldPrice, field: 'p_old_price'},
                {fn: validateQuantity, field: 'p_qty'},
                {fn: validateFeaturedPhoto, field: 'p_featured_photo'}
            ];
            
            var firstInvalidField = null;
            var allValid = true;
            
            validations.forEach(function(item){
                var isValid = item.fn();
                if(!isValid && !firstInvalidField){
                    firstInvalidField = item.field;
                }
                if(!isValid) allValid = false;
            });
            
            if(!allValid){
                e.preventDefault();
                // Scroll to first invalid field
                if(firstInvalidField){
                    var field = document.getElementById(firstInvalidField);
                    if(field){
                        field.scrollIntoView({behavior: 'smooth', block: 'center'});
                        field.focus();
                    }
                }
            }
        });
    })();
});
</script>
</body>
</html> 
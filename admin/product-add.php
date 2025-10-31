<?php require_once('header.php'); ?>

<style>
.error-msg{color:#e74c3c;font-size:12px;margin-top:6px;display:none;opacity:0;transition:opacity .2s ease}
.invalid{border-color:#e74c3c !important}
.error-msg.show{display:block;opacity:1}
</style>

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
		        	$statement->execute(array($final_name1[$i],$ai_id));
		        }
            }            
        }

		// Generate unique image name with timestamp to prevent conflicts
		$timestamp = time();
		$final_name = 'product-featured-'.$ai_id.'-'.$timestamp.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

		//Saving data into the main table tbl_product
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
										ecat_id
									) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
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
										$_POST['p_is_featured'],
										$_POST['p_is_active'],
										$_POST['ecat_id']
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
	
    	$success_message = 'Product is added successfully.';
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
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.modern-page-header h1 {
    margin: 0;
    font-size: 2rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.modern-page-header .subtitle {
    margin-top: 0.5rem;
    opacity: 0.9;
    font-size: 1.1rem;
}

.header-actions {
    margin-top: 1rem;
}

.btn-back {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
    color: #667eea;
    border: 2px solid rgba(255,255,255,0.3);
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-back:hover {
    background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    color: #5a67d8;
    text-decoration: none;
}

.modern-form-container {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid #e3e6f0;
    overflow: hidden;
    margin-bottom: 2rem;
}

.form-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
    padding: 1.5rem;
    border-bottom: 1px solid #e3e6f0;
}

.form-header h3 {
    margin: 0;
    color: #2c3e50;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.form-body {
    padding: 2rem;
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #e9ecef;
}

.form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.modern-form-group {
    margin-bottom: 1.5rem;
}

.modern-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.modern-form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.95rem;
}

.required {
    color: #e74a3b;
    margin-left: 0.25rem;
}

.modern-form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.modern-form-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.modern-form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
    cursor: pointer;
}

.modern-form-select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.modern-form-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
    min-height: 120px;
    resize: vertical;
}

.modern-form-textarea:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.file-upload-area {
    border: 2px dashed #e3e6f0;
    border-radius: 8px;
    padding: 1.5rem;
    text-align: center;
    background: #f8f9fc;
    transition: all 0.3s ease;
}

.file-upload-area:hover {
    border-color: #667eea;
    background: #f0f2ff;
}

.file-upload-area input[type="file"] {
    margin-top: 0.5rem;
}

.photo-upload-table {
    width: 100%;
    border-collapse: collapse;
}

.photo-upload-table td {
    padding: 0.5rem;
    vertical-align: middle;
}

.add-photo-btn {
    background: #28a745;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.add-photo-btn:hover {
    background: #218838;
}

.remove-photo-btn {
    background: #dc3545;
    color: white;
    border: none;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.remove-photo-btn:hover {
    background: #c82333;
}

.form-actions {
    padding: 1.5rem 2rem;
    background: #f8f9fc;
    border-top: 1px solid #e3e6f0;
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-cancel {
    background: #6c757d;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-cancel:hover {
    background: #5a6268;
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
}

.modern-alert {
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
}

.modern-alert.success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border: 1px solid #c3e6cb;
}

.modern-alert.error {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.fade-in {
    animation: fadeIn 0.6s ease-out;
}

.slide-in {
    animation: slideIn 0.8s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.price-note {
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 0.25rem;
}
</style>

<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-plus-square"></i>
        Add New Product
    </h1>
    <div class="subtitle">Create a new product listing for your store</div>
    <div class="header-actions">
        <a href="product.php" class="btn-back">
            <i class="fa fa-arrow-left"></i> Back to Products
        </a>
    </div>
</div>

<?php if($error_message): ?>
<div class="modern-alert error fade-in">
    <i class="fa fa-exclamation-triangle"></i>
    <?php echo $error_message; ?>
</div>
<?php endif; ?>

<?php if($success_message): ?>
<div class="modern-alert success fade-in">
    <i class="fa fa-check-circle"></i>
    <?php echo $success_message; ?>
</div>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="modern-form-container slide-in">
        <div class="form-header">
            <h3>
                <i class="fa fa-sitemap"></i>
                Category & Basic Information
            </h3>
        </div>
        
        <div class="form-body">
            <div class="form-section">
                <div class="section-title">
                    <i class="fa fa-tags"></i>
                    Product Categories
                </div>
                
                <div class="modern-form-group">
                    <label class="modern-form-label">
                        Top Category<span class="required">*</span>
                    </label>
                    <select name="tcat_id" class="modern-form-select top-cat" required>
                        <option value="">Select Top Category</option>
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
                </div>
                
                <div class="modern-form-group">
                    <label class="modern-form-label">
                        Mid Category<span class="required">*</span>
                    </label>
                    <select name="mcat_id" class="modern-form-select mid-cat" required>
                        <option value="">Select Mid Category</option>
                    </select>
                </div>
                
                <div class="modern-form-group">
                    <label class="modern-form-label">
                        End Category<span class="required">*</span>
                    </label>
                    <select name="ecat_id" class="modern-form-select end-cat" required>
                        <option value="">Select End Category</option>
                    </select>
                </div>
            </div>
            
            <div class="form-section">
                <div class="section-title">
                    <i class="fa fa-info-circle"></i>
                    Product Details
                </div>
                
                <div class="modern-form-group">
                    <label class="modern-form-label">
                        Product Name<span class="required">*</span>
                    </label>
                    <input type="text" name="p_name" id="p_name" class="modern-form-input" 
                           placeholder="Enter product name" required>
                    <span class="error-msg" id="p_name_error"></span>
                </div>
                
                <div class="modern-form-row">
                    <div class="modern-form-group">
                        <label class="modern-form-label">
                            Old Price
                        </label>
                        <input type="number" name="p_old_price" id="p_old_price" class="modern-form-input" 
                               placeholder="0" step="0.01">
                        <span class="error-msg" id="p_old_price_error"></span>
                        <div class="price-note">Original price (optional)</div>
                    </div>
                    
                    <div class="modern-form-group">
                        <label class="modern-form-label">
                            Current Price<span class="required">*</span>
                        </label>
                        <input type="number" name="p_current_price" id="p_current_price" class="modern-form-input" 
                               placeholder="0" step="0.01" required>
                        <span class="error-msg" id="p_current_price_error"></span>
                        <div class="price-note">Selling price in INR</div>
                    </div>
                </div>
                
                <div class="modern-form-group">
                    <label class="modern-form-label">
                        Quantity<span class="required">*</span>
                    </label>
                    <input type="number" name="p_qty" id="p_qty" class="modern-form-input" 
                           placeholder="0" min="0" required>
                    <span class="error-msg" id="p_qty_error"></span>
                </div>
            </div>
            
            <div class="form-section">
                <div class="section-title">
                    <i class="fa fa-cogs"></i>
                    Product Attributes
                </div>
                
                <div class="modern-form-row">
                    <div class="modern-form-group">
                        <label class="modern-form-label">
                            Available Sizes
                        </label>
                        <select name="size[]" class="modern-form-select" multiple>
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
                    </div>
                    
                    <div class="modern-form-group">
                        <label class="modern-form-label">
                            Available Colors
                        </label>
                        <select name="color[]" class="modern-form-select" multiple>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modern-form-container slide-in">
        <div class="form-header">
            <h3>
                <i class="fa fa-camera"></i>
                Product Images
            </h3>
        </div>
        
        <div class="form-body">
            <div class="form-section">
                <div class="section-title">
                    <i class="fa fa-star"></i>
                    Featured Image
                </div>
                
                <div class="modern-form-group">
                    <label class="modern-form-label">
                        Featured Photo<span class="required">*</span>
                    </label>
                    <div class="file-upload-area">
                        <i class="fa fa-cloud-upload" style="font-size: 2rem; color: #667eea; margin-bottom: 0.5rem;"></i>
                        <div>Choose main product image</div>
                        <input type="file" name="p_featured_photo" id="p_featured_photo" accept="image/*" required>
                        <span class="error-msg" id="p_featured_photo_error"></span>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <div class="section-title">
                    <i class="fa fa-images"></i>
                    Additional Images
                </div>
                
                <div class="modern-form-group">
                    <label class="modern-form-label">
                        Other Photos
                    </label>
                    <table id="ProductTable" class="photo-upload-table">
                        <tbody>
                            <tr>
                                <td>
                                    <input type="file" name="photo[]" accept="image/*" class="modern-form-input">
                                </td>
                                <td style="width:80px;">
                                    <button type="button" class="remove-photo-btn Delete">Remove</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" id="btnAddNew" class="add-photo-btn" style="margin-top: 1rem;">
                        <i class="fa fa-plus"></i> Add More Images
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modern-form-container slide-in">
        <div class="form-header">
            <h3>
                <i class="fa fa-file-text"></i>
                Product Content
            </h3>
        </div>
        
        <div class="form-body">
            <div class="modern-form-group">
                <label class="modern-form-label">
                    Product Description
                </label>
                <textarea name="p_description" class="modern-form-textarea" id="editor1" 
                          placeholder="Detailed product description..."></textarea>
            </div>
            
            <div class="modern-form-group">
                <label class="modern-form-label">
                    Short Description
                </label>
                <textarea name="p_short_description" class="modern-form-textarea" id="editor2" 
                          placeholder="Brief product summary..."></textarea>
            </div>
            
            <div class="modern-form-group">
                <label class="modern-form-label">
                    Features
                </label>
                <textarea name="p_feature" class="modern-form-textarea" id="editor3" 
                          placeholder="Key product features..."></textarea>
            </div>
            
            <div class="modern-form-group">
                <label class="modern-form-label">
                    Conditions
                </label>
                <textarea name="p_condition" class="modern-form-textarea" id="editor4" 
                          placeholder="Product condition details..."></textarea>
            </div>
            
            <div class="modern-form-group">
                <label class="modern-form-label">
                    Return Policy
                </label>
                <textarea name="p_return_policy" class="modern-form-textarea" id="editor5" 
                          placeholder="Return policy information..."></textarea>
            </div>
        </div>
    </div>
    
    <div class="modern-form-container slide-in">
        <div class="form-header">
            <h3>
                <i class="fa fa-cog"></i>
                Product Settings
            </h3>
        </div>
        
        <div class="form-body">
            <div class="modern-form-row">
                <div class="modern-form-group">
                    <label class="modern-form-label">
                        Featured Product
                    </label>
                    <select name="p_is_featured" class="modern-form-select">
                        <option value="0">No - Regular product</option>
                        <option value="1">Yes - Feature on homepage</option>
                    </select>
                </div>
                
                <div class="modern-form-group">
                    <label class="modern-form-label">
                        Product Status
                    </label>
                    <select name="p_is_active" class="modern-form-select">
                        <option value="0">Inactive - Hidden from store</option>
                        <option value="1">Active - Visible to customers</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <a href="product.php" class="btn-cancel">
                <i class="fa fa-times"></i> Cancel
            </a>
            <button type="submit" name="form1" class="btn-submit">
                <i class="fa fa-save"></i> Add Product
            </button>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    // Category cascade functionality
    $('.top-cat').on('change', function() {
        var tcat_id = $(this).val();
        if(tcat_id) {
            $.ajax({
                url: 'get-mid-category.php',
                type: 'POST',
                data: {tcat_id: tcat_id},
                success: function(data) {
                    $('.mid-cat').html(data);
                    $('.end-cat').html('<option value="">Select End Category</option>');
                }
            });
        } else {
            $('.mid-cat').html('<option value="">Select Mid Category</option>');
            $('.end-cat').html('<option value="">Select End Category</option>');
        }
    });
    
    $('.mid-cat').on('change', function() {
        var mcat_id = $(this).val();
        if(mcat_id) {
            $.ajax({
                url: 'get-end-category.php',
                type: 'POST',
                data: {mcat_id: mcat_id},
                success: function(data) {
                    $('.end-cat').html(data);
                }
            });
        } else {
            $('.end-cat').html('<option value="">Select End Category</option>');
        }
    });
    
    // Add more photo inputs
    $("#btnAddNew").click(function () {
        var num = $('.photo-upload-table tbody tr').length;
        var newRow = '<tr><td><input type="file" name="photo[]" accept="image/*" class="modern-form-input"></td><td><button type="button" class="remove-photo-btn Delete">Remove</button></td></tr>';
        $("#ProductTable tbody").append(newRow);
    });
    
    // Remove photo input
    $(document).on('click', '.Delete', function() {
        if($('.photo-upload-table tbody tr').length > 1) {
            $(this).closest('tr').remove();
        }
    });
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
    var form = document.querySelector('form[enctype="multipart/form-data"]');
    if(!form) return;
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
        var ok = [validateProductName(), validateCurrentPrice(), validateOldPrice(), validateQuantity(), validateFeaturedPhoto()].every(Boolean);
        if(!ok){ e.preventDefault(); }
    });
})();
</script>

</section>

<?php require_once('footer.php'); ?>
<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['tcat_name'])) {
        $valid = 0;
        $error_message .= "Top Category Name can not be empty<br>";
    } else {
		// Duplicate Top Category checking
    	// current Top Category name that is in the database
    	$statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE tcat_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$current_tcat_name = $row['tcat_name'];
		}

		$statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE tcat_name=? and tcat_name!=?");
    	$statement->execute(array($_POST['tcat_name'],$current_tcat_name));
    	$total = $statement->rowCount();							
    	if($total) {
    		$valid = 0;
        	$error_message .= 'Top Category name already exists<br>';
    	}
    }

    if($valid == 1) {    	
		// updating into the database
		$statement = $pdo->prepare("UPDATE tbl_top_category SET tcat_name=?,show_on_menu=? WHERE tcat_id=?");
		$statement->execute(array($_POST['tcat_name'],$_POST['show_on_menu'],$_REQUEST['id']));

    	$success_message = 'Top Category is updated successfully.';
    }
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE tcat_id=?");
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
    max-width: 800px;
    margin: 0 auto;
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

.modern-form-input, .modern-form-select {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.modern-form-input:focus, .modern-form-select:focus {
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

.file-help-text {
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 0.5rem;
    font-style: italic;
}

.existing-photo {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e3e6f0;
}

.existing-photo img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e3e6f0;
}

.photo-info {
    flex: 1;
}

.photo-info h4 {
    margin: 0 0 0.5rem 0;
    color: #2c3e50;
    font-size: 1.1rem;
}

.photo-info p {
    margin: 0;
    color: #6c757d;
    font-size: 0.9rem;
}

.modern-checkbox-group {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e3e6f0;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modern-checkbox-group:hover {
    background: rgba(102, 126, 234, 0.05);
    border-color: #667eea;
}

.modern-checkbox {
    width: 20px;
    height: 20px;
    accent-color: #667eea;
    cursor: pointer;
}

.checkbox-label {
    font-weight: 500;
    color: #2c3e50;
    cursor: pointer;
    margin: 0;
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

.form-actions {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e3e6f0;
    text-align: center;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
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
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .existing-photo {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<?php
foreach ($result as $row) {
	$tcat_name = $row['tcat_name'];
	$show_on_menu = $row['show_on_menu'];
	$photo = $row['photo'];
}
?>

<div class="modern-page-header" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-folder-open"></i>
        Edit Top Level Category
    </h1>
    <p class="subtitle">Update top-level category information and settings</p>
    <div style="margin-top: 1rem;">
        <a href="top-category.php" class="modern-btn-secondary">
            <i class="fa fa-list"></i>
            View All Categories
        </a>
    </div>
</div>

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
                    <div class="form-row">
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fa fa-tag"></i>
                                Category Name
                                <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   name="tcat_name" 
                                   class="modern-form-input" 
                                   value="<?php echo htmlspecialchars($tcat_name); ?>"
                                   placeholder="Enter category name"
                                   required>
                        </div>
                        
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fa fa-eye"></i>
                                Show on Menu
                            </label>
                            <select name="show_on_menu" class="modern-form-select">
                                <option value="0" <?php if($show_on_menu == 0) {echo 'selected';} ?>>No</option>
                                <option value="1" <?php if($show_on_menu == 1) {echo 'selected';} ?>>Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="modern-form-group">
                        <label class="modern-form-label">
                            <i class="fa fa-image"></i>
                            Current Category Photo
                        </label>
                        <div class="existing-photo">
                            <img src="../assets/uploads/<?php echo htmlspecialchars($photo); ?>" alt="Category Photo">
                            <div class="photo-info">
                                <h4>Current Image</h4>
                                <p>Filename: <?php echo htmlspecialchars($photo); ?></p>
                                <p>Upload a new image below to replace this one</p>
                            </div>
                        </div>
                    </div>

                    <div class="modern-form-group">
                        <label class="modern-form-label">
                            <i class="fa fa-upload"></i>
                            Change Category Photo
                        </label>
                        <input type="file" 
                               name="photo" 
                               class="modern-file-input"
                               accept=".jpg,.jpeg,.png,.gif">
                        <div class="file-help-text">
                            <i class="fa fa-info-circle"></i>
                            Only JPG, JPEG, PNG and GIF files are allowed
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="form1" class="modern-btn">
                            <i class="fa fa-save"></i>
                            Update Category
                        </button>
                        <a href="top-category.php" class="modern-btn-secondary">
                            <i class="fa fa-times"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
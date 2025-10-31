<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['tcat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a top level category<br>";
    }

    if(empty($_POST['mcat_name'])) {
        $valid = 0;
        $error_message .= "Mid Level Category Name can not be empty<br>";
    }

    if($valid == 1) {    	
		// updating into the database
		$statement = $pdo->prepare("UPDATE tbl_mid_category SET mcat_name=?,tcat_id=? WHERE mcat_id=?");
		$statement->execute(array($_POST['mcat_name'],$_POST['tcat_id'],$_REQUEST['id']));

    	$success_message = 'Mid Level Category is updated successfully.';
    }
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE mcat_id=?");
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
    max-width: 700px;
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
}
</style>

<?php
foreach ($result as $row) {
	$mcat_name = $row['mcat_name'];
	$tcat_id = $row['tcat_id'];
}
?>

<div class="modern-page-header" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-sitemap"></i>
        Edit Mid Level Category
    </h1>
    <p class="subtitle">Update mid-level category information and parent category assignment</p>
    <div style="margin-top: 1rem;">
        <a href="mid-category.php" class="modern-btn-secondary">
            <i class="fa fa-list"></i>
            View All Mid Categories
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
                <form action="" method="post">
                    <div class="form-row">
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fa fa-folder"></i>
                                Top Level Category
                                <span class="required">*</span>
                            </label>
                            <select name="tcat_id" class="modern-form-select" required>
                                <option value="">Select Top Level Category</option>
                                <?php
                                $statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    ?>
                                    <option value="<?php echo $row['tcat_id']; ?>" <?php if($row['tcat_id'] == $tcat_id) {echo 'selected';} ?>><?php echo htmlspecialchars($row['tcat_name']); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fa fa-tag"></i>
                                Mid Category Name
                                <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   name="mcat_name" 
                                   class="modern-form-input" 
                                   value="<?php echo htmlspecialchars($mcat_name); ?>"
                                   placeholder="Enter mid-level category name"
                                   required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="form1" class="modern-btn">
                            <i class="fa fa-save"></i>
                            Update Category
                        </button>
                        <a href="mid-category.php" class="modern-btn-secondary">
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
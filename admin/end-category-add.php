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

    if(empty($_POST['ecat_name'])) {
        $valid = 0;
        $error_message .= "End level category name can not be empty<br>";
    }

    if($valid == 1) {

		//Saving data into the main table tbl_end_category
		$statement = $pdo->prepare("INSERT INTO tbl_end_category (ecat_name,mcat_id) VALUES (?,?)");
		$statement->execute(array($_POST['ecat_name'],$_POST['mcat_id']));
	
    	$success_message = 'End Level Category is added successfully.';
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
</style>

<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-folder"></i>
        Add End Category
    </h1>
    <div class="subtitle">Create a new end-level product category</div>
    <div class="header-actions">
        <a href="end-category.php" class="btn-back">
            <i class="fa fa-arrow-left"></i> Back to Categories
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

<div class="modern-form-container slide-in">
    <div class="form-header">
        <h3>
            <i class="fa fa-info-circle"></i>
            Category Information
        </h3>
    </div>
    
    <form action="" method="post">
        <div class="form-body">
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
                    Category Name<span class="required">*</span>
                </label>
                <input type="text" name="ecat_name" class="modern-form-input" 
                       placeholder="Enter end-level category name (e.g., iPhone Cases, Cotton T-Shirts)" 
                       required>
            </div>
        </div>
        
        <div class="form-actions">
            <a href="end-category.php" class="btn-cancel">
                <i class="fa fa-times"></i> Cancel
            </a>
            <button type="submit" name="form1" class="btn-submit">
                <i class="fa fa-save"></i> Add Category
            </button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $('.top-cat').on('change', function() {
        var tcat_id = $(this).val();
        if(tcat_id) {
            $.ajax({
                url: 'get-mid-category.php',
                type: 'POST',
                data: {tcat_id: tcat_id},
                success: function(data) {
                    $('.mid-cat').html(data);
                }
            });
        } else {
            $('.mid-cat').html('<option value="">Select Mid Category</option>');
        }
    });
});
</script>

<?php require_once('footer.php'); ?>
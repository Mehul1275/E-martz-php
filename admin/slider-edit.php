<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
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

		if($path == '') {
			$statement = $pdo->prepare("UPDATE tbl_slider SET heading=?, content=?, button_text=?, button_url=?, position=? WHERE id=?");
    		$statement->execute(array($_POST['heading'],$_POST['content'],$_POST['button_text'],$_POST['button_url'],$_POST['position'],$_REQUEST['id']));
		} else {

			unlink('../assets/uploads/'.$_POST['current_photo']);

			$final_name = 'slider-'.$_REQUEST['id'].'.'.$ext;
        	move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

        	$statement = $pdo->prepare("UPDATE tbl_slider SET photo=?, heading=?, content=?, button_text=?, button_url=?, position=? WHERE id=?");
    		$statement->execute(array($final_name,$_POST['heading'],$_POST['content'],$_POST['button_text'],$_POST['button_url'],$_POST['position'],$_REQUEST['id']));
		}	   

	    $success_message = 'Slider is updated successfully!';
	}
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_slider WHERE id=?");
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
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 1px solid rgba(255,255,255,0.3);
}

.btn-back:hover {
    background: rgba(255,255,255,0.3);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.modern-form-container {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    border: 1px solid #e3e6f0;
}

.form-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #dee2e6;
}

.form-header h3 {
    margin: 0;
    color: #495057;
    font-size: 1.5rem;
    font-weight: 600;
}

.form-header p {
    margin: 0.5rem 0 0 0;
    color: #6c757d;
    font-size: 1rem;
}

.form-body {
    padding: 2rem;
}

.current-image-section {
    background: #f8f9fc;
    padding: 1.5rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    border: 1px solid #e3e6f0;
}

.current-image {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border: 2px solid #e3e6f0;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 1.5rem;
}

.form-row.full-width {
    grid-template-columns: 1fr;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.modern-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #fff;
}

.modern-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.modern-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #fff;
    min-height: 120px;
    resize: vertical;
    font-family: inherit;
}

.modern-textarea:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.modern-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #fff;
    cursor: pointer;
}

.modern-select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.file-upload-container {
    position: relative;
    display: inline-block;
    width: 100%;
}

.file-upload-input {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.file-upload-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1.5rem;
    border: 2px dashed #e3e6f0;
    border-radius: 8px;
    background: #f8f9fc;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
}

.file-upload-label:hover {
    border-color: #667eea;
    background: rgba(102, 126, 234, 0.05);
    color: #667eea;
}

.file-upload-label.has-file {
    border-color: #28a745;
    background: rgba(40, 167, 69, 0.05);
    color: #28a745;
}

.file-info {
    margin-top: 0.5rem;
    font-size: 0.85rem;
    color: #6c757d;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-start;
    padding-top: 1rem;
    border-top: 1px solid #e3e6f0;
    margin-top: 2rem;
}

.modern-btn {
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a6fd8, #6a4190);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    color: white;
    text-decoration: none;
}

.modern-alert {
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    border-left: 4px solid;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.modern-alert-success {
    background: rgba(40, 167, 69, 0.1);
    border-left-color: #28a745;
    color: #155724;
}

.modern-alert-danger {
    background: rgba(220, 53, 69, 0.1);
    border-left-color: #dc3545;
    color: #721c24;
}

.alert-icon {
    font-size: 1.2rem;
    margin-top: 0.1rem;
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

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .form-body {
        padding: 1.5rem;
    }
    
    .modern-page-header {
        padding: 1.5rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>

<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-edit"></i>
        Edit Slider
    </h1>
    <div class="subtitle">Update slider information and content</div>
    <div class="header-actions">
        <a href="slider.php" class="btn-back">
            <i class="fa fa-arrow-left"></i> Back to Sliders
        </a>
    </div>
</div>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_slider WHERE id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$photo       = $row['photo'];
	$heading     = $row['heading'];
	$content     = $row['content'];
	$button_text = $row['button_text'];
	$button_url  = $row['button_url'];
	$position    = $row['position'];
}
?>

<div class="row">
    <div class="col-md-12">
        <?php if($error_message): ?>
        <div class="modern-alert modern-alert-danger fade-in">
            <i class="fa fa-exclamation-triangle alert-icon"></i>
            <div>
                <strong>Error!</strong><br>
                <?php echo $error_message; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if($success_message): ?>
        <div class="modern-alert modern-alert-success fade-in">
            <i class="fa fa-check-circle alert-icon"></i>
            <div>
                <strong>Success!</strong><br>
                <?php echo $success_message; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="modern-form-container slide-in">
            <div class="form-header">
                <h3><i class="fa fa-edit"></i> Edit Slider Information</h3>
                <p>Update the slider details and upload a new image if needed</p>
            </div>
            
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="current_photo" value="<?php echo $photo; ?>">
                <div class="form-body">
                    <div class="current-image-section">
                        <h4 style="margin: 0 0 1rem 0; color: #495057;"><i class="fa fa-image"></i> Current Slider Image</h4>
                        <img src="../assets/uploads/<?php echo $photo; ?>" alt="Current Slider" class="current-image">
                    </div>
                    
                    <div class="form-row full-width">
                        <div class="form-group">
                            <label class="form-label">Replace Image (Optional)</label>
                            <div class="file-upload-container">
                                <input type="file" name="photo" class="file-upload-input" id="photo" accept=".jpg,.jpeg,.png,.gif">
                                <label for="photo" class="file-upload-label" id="photoLabel">
                                    <i class="fa fa-cloud-upload" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <div style="font-weight: 600; margin-bottom: 0.25rem;">Choose new image</div>
                                        <div style="font-size: 0.9rem;">Leave empty to keep current image</div>
                                    </div>
                                </label>
                            </div>
                            <div class="file-info">
                                <i class="fa fa-info-circle"></i> Supported formats: JPG, JPEG, PNG, GIF. Recommended size: 1920x800px
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Slider Heading</label>
                            <input type="text" name="heading" class="modern-input" 
                                   placeholder="Enter slider heading" 
                                   value="<?php echo htmlspecialchars($heading); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Content Position</label>
                            <select name="position" class="modern-select">
                                <option value="Left" <?php if($position == 'Left') echo 'selected'; ?>>Left</option>
                                <option value="Center" <?php if($position == 'Center') echo 'selected'; ?>>Center</option>
                                <option value="Right" <?php if($position == 'Right') echo 'selected'; ?>>Right</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row full-width">
                        <div class="form-group">
                            <label class="form-label">Slider Content</label>
                            <textarea name="content" class="modern-textarea" 
                                      placeholder="Enter slider description or content..."><?php echo htmlspecialchars($content); ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Button Text</label>
                            <input type="text" name="button_text" class="modern-input" 
                                   placeholder="e.g., Shop Now, Learn More" 
                                   value="<?php echo htmlspecialchars($button_text); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Button URL</label>
                            <input type="url" name="button_url" class="modern-input" 
                                   placeholder="https://example.com" 
                                   value="<?php echo htmlspecialchars($button_url); ?>">
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="form1" class="modern-btn btn-primary">
                            <i class="fa fa-save"></i> Update Slider
                        </button>
                        <a href="slider.php" class="modern-btn btn-secondary">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('photo');
    const fileLabel = document.getElementById('photoLabel');
    
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const fileName = this.files[0].name;
            const fileSize = (this.files[0].size / 1024 / 1024).toFixed(2);
            
            fileLabel.innerHTML = `
                <i class="fa fa-check-circle" style="font-size: 1.5rem; color: #28a745;"></i>
                <div>
                    <div style="font-weight: 600; margin-bottom: 0.25rem;">${fileName}</div>
                    <div style="font-size: 0.9rem;">Size: ${fileSize} MB</div>
                </div>
            `;
            fileLabel.classList.add('has-file');
        }
    });
});
</script>

<?php require_once('footer.php'); ?>
<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

	if(empty($_POST['faq_title'])) {
		$valid = 0;
		$error_message .= 'Title can not be empty<br>';
	}

	if(empty($_POST['faq_content'])) {
		$valid = 0;
		$error_message .= 'Content can not be empty<br>';
	}

	if($valid == 1) {
	
		$statement = $pdo->prepare("INSERT INTO tbl_faq (faq_title,faq_content) VALUES (?,?)");
		$statement->execute(array($_POST['faq_title'],$_POST['faq_content']));
			
		$success_message = 'FAQ is added successfully!';

		unset($_POST['faq_title']);
		unset($_POST['faq_content']);
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

.modern-form-input, .modern-form-textarea {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.modern-form-input:focus, .modern-form-textarea:focus {
    outline: none;
    border-color: #667eea;
    background-color: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.modern-form-textarea {
    min-height: 200px;
    resize: vertical;
    font-family: inherit;
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
    }
}
</style>

<div class="modern-page-header" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-question-circle"></i>
        Add FAQ
    </h1>
    <p class="subtitle">Create a new frequently asked question to help your customers</p>
    <div style="margin-top: 1rem;">
        <a href="faq.php" class="modern-btn-secondary">
            <i class="fa fa-list"></i>
            View All FAQs
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
                    <div class="modern-form-group">
                        <label class="modern-form-label">
                            <i class="fa fa-tag"></i>
                            FAQ Title
                            <span class="required">*</span>
                        </label>
                        <input type="text" 
                               name="faq_title" 
                               class="modern-form-input" 
                               placeholder="Enter the FAQ question or title"
                               value="<?php if(isset($_POST['faq_title'])){echo htmlspecialchars($_POST['faq_title']);} ?>"
                               required>
                    </div>

                    <div class="modern-form-group">
                        <label class="modern-form-label">
                            <i class="fa fa-file-text-o"></i>
                            FAQ Content
                            <span class="required">*</span>
                        </label>
                        <textarea name="faq_content" 
                                  id="editor1" 
                                  class="modern-form-textarea" 
                                  placeholder="Enter the detailed answer to this FAQ"
                                  required><?php if(isset($_POST['faq_content'])){echo htmlspecialchars($_POST['faq_content']);} ?></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="form1" class="modern-btn">
                            <i class="fa fa-save"></i>
                            Add FAQ
                        </button>
                        <a href="faq.php" class="modern-btn-secondary">
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
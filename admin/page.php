<?php require_once('header.php'); ?>

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

.modern-tabs-container {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid #e3e6f0;
}

.modern-nav-tabs {
    background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
    border-bottom: 2px solid #e3e6f0;
    padding: 0;
    margin: 0;
    display: flex;
    flex-wrap: wrap;
}

.modern-nav-tabs li {
    list-style: none;
    margin: 0;
}

.modern-nav-tabs li a {
    display: block;
    padding: 1rem 1.5rem;
    color: #5a5c69;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    background: none;
    position: relative;
}

.modern-nav-tabs li a:hover {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
}

.modern-nav-tabs li.active a {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    font-weight: 600;
}

.modern-form-container {
    padding: 2rem;
}

.form-section {
    background: #f8f9fc;
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.modern-label {
    display: block;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.modern-form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: white;
}

.modern-form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.modern-form-control textarea {
    resize: vertical;
    min-height: 100px;
}

.form-actions {
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid #e3e6f0;
}

.modern-btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.modern-btn-success {
    background: linear-gradient(135deg, #1cc88a, #17a673);
    color: white;
}

.modern-btn-success:hover {
    background: linear-gradient(135deg, #17a673, #138f5f);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(28, 200, 138, 0.3);
    color: white;
    text-decoration: none;
}

.modern-btn-info {
    background: linear-gradient(135deg, #36b9cc, #258391);
    color: white;
}

.modern-btn-info:hover {
    background: linear-gradient(135deg, #258391, #1e6b73);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(54, 185, 204, 0.3);
    color: white;
    text-decoration: none;
}

.alert {
    border-radius: 8px;
    border: none;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
}

.alert-success {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    color: #155724;
    border-left: 4px solid #28a745;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da, #f5c6cb);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

/* Animation keyframes */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Animation classes */
.fade-in {
    animation: fadeIn 0.6s ease-out;
}

.slide-in {
    animation: slideIn 0.8s ease-out;
}

.tab-content {
    background: white;
}

.tab-pane {
    display: none;
}

.tab-pane.active {
    display: block;
}

/* Responsive design */
@media (max-width: 768px) {
    .modern-nav-tabs {
        flex-direction: column;
    }
    
    .modern-nav-tabs li a {
        padding: 0.75rem 1rem;
    }
    
    .modern-form-container {
        padding: 1rem;
    }
}
</style>

<?php

if(isset($_POST['form_about'])) {
    
    $valid = 1;

    if(empty($_POST['about_title'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }

    if(empty($_POST['about_content'])) {
        $valid = 0;
        $error_message .= 'Content can not be empty<br>';
    }

    if($valid == 1) {
        // updating the database without banner image
        $statement = $pdo->prepare("UPDATE tbl_page SET about_title=?,about_content=?,about_meta_title=?,about_meta_keyword=?,about_meta_description=? WHERE id=1");
        $statement->execute(array($_POST['about_title'],$_POST['about_content'],$_POST['about_meta_title'],$_POST['about_meta_keyword'],$_POST['about_meta_description']));

        $success_message = 'About Page Information is updated successfully.';
        
    }
    
}



if(isset($_POST['form_faq'])) {
    
    $valid = 1;

    if(empty($_POST['faq_title'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }

    if($valid == 1) {
        // updating the database without banner image
        $statement = $pdo->prepare("UPDATE tbl_page SET faq_title=?,faq_meta_title=?,faq_meta_keyword=?,faq_meta_description=? WHERE id=1");
        $statement->execute(array($_POST['faq_title'],$_POST['faq_meta_title'],$_POST['faq_meta_keyword'],$_POST['faq_meta_description']));

        $success_message = 'FAQ Page Information is updated successfully.';
        
    }
    
}



if(isset($_POST['form_contact'])) {
    
    $valid = 1;

    if(empty($_POST['contact_title'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }

    if($valid == 1) {
        // updating the database without banner image
        $statement = $pdo->prepare("UPDATE tbl_page SET contact_title=?,contact_meta_title=?,contact_meta_keyword=?,contact_meta_description=? WHERE id=1");
        $statement->execute(array($_POST['contact_title'],$_POST['contact_meta_title'],$_POST['contact_meta_keyword'],$_POST['contact_meta_description']));

        $success_message = 'Contact Page Information is updated successfully.';
        
    }
    
}

// --- Terms & Conditions Save Logic ---
if(isset($_POST['form_tnc'])) {
    $valid = 1;
    if(empty($_POST['tnc_title'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }
    if(empty($_POST['tnc_content'])) {
        $valid = 0;
        $error_message .= 'Content can not be empty<br>';
    }
    if($valid == 1) {
        $statement = $pdo->prepare("UPDATE tbl_page SET tnc_title=?, tnc_content=?, tnc_meta_title=?, tnc_meta_keyword=?, tnc_meta_description=? WHERE id=1");
        $statement->execute(array($_POST['tnc_title'], $_POST['tnc_content'], $_POST['tnc_meta_title'], $_POST['tnc_meta_keyword'], $_POST['tnc_meta_description']));
        $success_message = 'Terms & Conditions Page Information is updated successfully.';
    }
}

// --- Shipping & Returns Save Logic ---
if(isset($_POST['form_shipping'])) {
    $valid = 1;
    if(empty($_POST['shipping_title'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }
    if(empty($_POST['shipping_content'])) {
        $valid = 0;
        $error_message .= 'Content can not be empty<br>';
    }
    if($valid == 1) {
        $statement = $pdo->prepare("UPDATE tbl_page SET shipping_title=?, shipping_content=?, shipping_meta_title=?, shipping_meta_keyword=?, shipping_meta_description=? WHERE id=1");
        $statement->execute(array($_POST['shipping_title'], $_POST['shipping_content'], $_POST['shipping_meta_title'], $_POST['shipping_meta_keyword'], $_POST['shipping_meta_description']));
        $success_message = 'Shipping & Returns Page Information is updated successfully.';
    }
}

// --- Privacy Policy Save Logic ---
if(isset($_POST['form_privacy'])) {
    $valid = 1;
    if(empty($_POST['privacy_title'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }
    if(empty($_POST['privacy_content'])) {
        $valid = 0;
        $error_message .= 'Content can not be empty<br>';
    }
    if($valid == 1) {
        $statement = $pdo->prepare("UPDATE tbl_page SET privacy_title=?, privacy_content=?, privacy_meta_title=?, privacy_meta_keyword=?, privacy_meta_description=? WHERE id=1");
        $statement->execute(array($_POST['privacy_title'], $_POST['privacy_content'], $_POST['privacy_meta_title'], $_POST['privacy_meta_keyword'], $_POST['privacy_meta_description']));
        $success_message = 'Privacy Policy Page Information is updated successfully.';
    }
}

// --- Seller T&C Save Logic ---
if(isset($_POST['form_seller_tnc'])) {
    $valid = 1;
    if(empty($_POST['seller_tnc_title'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }
    if(empty($_POST['seller_tnc_content'])) {
        $valid = 0;
        $error_message .= 'Content can not be empty<br>';
    }
    if($valid == 1) {
        $statement = $pdo->prepare("UPDATE tbl_page SET seller_tnc_title=?, seller_tnc_content=?, seller_tnc_meta_title=?, seller_tnc_meta_keyword=?, seller_tnc_meta_description=? WHERE id=1");
        $statement->execute(array($_POST['seller_tnc_title'], $_POST['seller_tnc_content'], $_POST['seller_tnc_meta_title'], $_POST['seller_tnc_meta_keyword'], $_POST['seller_tnc_meta_description']));
        $success_message = 'Seller T&C Page Information is updated successfully.';
    }
}

?>

<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-file-text"></i>
        Page Settings
    </h1>
    <div class="subtitle">Manage website page content and SEO settings</div>
    <div style="margin-top: 1rem;">
        <button class="modern-btn modern-btn-info" onclick="location.reload()">
            <i class="fa fa-refresh"></i> Refresh
        </button>
    </div>
</div>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
foreach ($result as $row) {
    $about_title = $row['about_title'];
    $about_content = $row['about_content'];
    $about_banner = $row['about_banner'];
    $about_meta_title = $row['about_meta_title'];
    $about_meta_keyword = $row['about_meta_keyword'];
    $about_meta_description = $row['about_meta_description'];
    $faq_title = $row['faq_title'];
    $faq_banner = $row['faq_banner'];
    $faq_meta_title = $row['faq_meta_title'];
    $faq_meta_keyword = $row['faq_meta_keyword'];
    $faq_meta_description = $row['faq_meta_description'];
    $contact_title = $row['contact_title'];
    $contact_banner = $row['contact_banner'];
    $contact_meta_title = $row['contact_meta_title'];
    $contact_meta_keyword = $row['contact_meta_keyword'];
    $contact_meta_description = $row['contact_meta_description'];
    $tnc_title = $row['tnc_title'];
    $tnc_content = $row['tnc_content'];
    $tnc_banner = $row['tnc_banner'];
    $tnc_meta_title = $row['tnc_meta_title'];
    $tnc_meta_keyword = $row['tnc_meta_keyword'];
    $tnc_meta_description = $row['tnc_meta_description'];
    $shipping_title = $row['shipping_title'];
    $shipping_content = $row['shipping_content'];
    $shipping_banner = $row['shipping_banner'];
    $shipping_meta_title = $row['shipping_meta_title'];
    $shipping_meta_keyword = $row['shipping_meta_keyword'];
    $shipping_meta_description = $row['shipping_meta_description'];
    $privacy_title = $row['privacy_title'];
    $privacy_content = $row['privacy_content'];
    $privacy_banner = $row['privacy_banner'];
    $privacy_meta_title = $row['privacy_meta_title'];
    $privacy_meta_keyword = $row['privacy_meta_keyword'];
    $privacy_meta_description = $row['privacy_meta_description'];
    $seller_tnc_title = $row['seller_tnc_title'];
    $seller_tnc_content = $row['seller_tnc_content'];
    $seller_tnc_banner = $row['seller_tnc_banner'];
    $seller_tnc_meta_title = $row['seller_tnc_meta_title'];
    $seller_tnc_meta_keyword = $row['seller_tnc_meta_keyword'];
    $seller_tnc_meta_description = $row['seller_tnc_meta_description'];

}
?>


<?php if($error_message): ?>
<div class="alert alert-danger alert-dismissible fade-in">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-ban"></i> Error!</h4>
    <?php echo $error_message; ?>
</div>
<?php endif; ?>

<?php if($success_message): ?>
<div class="alert alert-success alert-dismissible fade-in">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i> Success!</h4>
    <?php echo $success_message; ?>
</div>
<?php endif; ?>

<section class="content">
    <div class="modern-tabs-container slide-in">
        <div class="nav-tabs-custom modern-tabs">
            <ul class="nav nav-tabs modern-nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-info-circle"></i> About Us</a></li>
                <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-question-circle"></i> FAQ</a></li>
                <li><a href="#tab_4" data-toggle="tab"><i class="fa fa-envelope"></i> Contact</a></li>
                <li><a href="#tab_tnc" data-toggle="tab"><i class="fa fa-file-text"></i> Terms & Conditions</a></li>
                <li><a href="#tab_shipping" data-toggle="tab"><i class="fa fa-truck"></i> Shipping & Returns</a></li>
                <li><a href="#tab_privacy" data-toggle="tab"><i class="fa fa-shield"></i> Privacy Policy</a></li>
                <li><a href="#tab_seller_tnc" data-toggle="tab"><i class="fa fa-handshake-o"></i> Seller T&C</a></li>
            </ul>

                    <!-- About us Page Content -->

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="modern-form-container">
                                <div class="form-section">
                                    <div class="form-group">
                                        <label class="modern-label">Page Title *</label>
                                        <input class="modern-form-control" type="text" name="about_title" value="<?php echo htmlspecialchars($about_title); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="modern-label">Page Content *</label>
                                        <textarea class="modern-form-control" name="about_content" id="editor1" rows="8" required><?php echo htmlspecialchars($about_content); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="modern-label">Meta Title</label>
                                        <input class="modern-form-control" type="text" name="about_meta_title" value="<?php echo htmlspecialchars($about_meta_title); ?>">
                                    </div>             
                                    <div class="form-group">
                                        <label class="modern-label">Meta Keywords</label>
                                        <textarea class="modern-form-control" name="about_meta_keyword" rows="3"><?php echo htmlspecialchars($about_meta_keyword); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="modern-label">Meta Description</label>
                                        <textarea class="modern-form-control" name="about_meta_description" rows="3"><?php echo htmlspecialchars($about_meta_description); ?></textarea>
                                    </div>                                    
                                    <div class="form-actions">
                                        <button type="submit" class="modern-btn modern-btn-success" name="form_about">
                                            <i class="fa fa-save"></i> Update About Page
                                        </button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>

        <!-- FAQ Page Content -->

                        <div class="tab-pane" id="tab_2">
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="modern-form-container">
                                <div class="form-section">
                                    <div class="form-group">
                                        <label class="modern-label">Page Title *</label>
                                        <input class="modern-form-control" type="text" name="faq_title" value="<?php echo htmlspecialchars($faq_title); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="modern-label">Meta Title</label>
                                        <input class="modern-form-control" type="text" name="faq_meta_title" value="<?php echo htmlspecialchars($faq_meta_title); ?>">
                                    </div>             
                                    <div class="form-group">
                                        <label class="modern-label">Meta Keywords</label>
                                        <textarea class="modern-form-control" name="faq_meta_keyword" rows="3"><?php echo htmlspecialchars($faq_meta_keyword); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="modern-label">Meta Description</label>
                                        <textarea class="modern-form-control" name="faq_meta_description" rows="3"><?php echo htmlspecialchars($faq_meta_description); ?></textarea>
                                    </div>                                    
                                    <div class="form-actions">
                                        <button type="submit" class="modern-btn modern-btn-success" name="form_faq">
                                            <i class="fa fa-save"></i> Update FAQ Page
                                        </button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>

                        <!-- End of FAQ Page Content -->

                        <div class="tab-pane" id="tab_4">
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="modern-form-container">
                                <div class="form-section">
                                    <div class="form-group">
                                        <label class="modern-label">Page Title *</label>
                                        <input class="modern-form-control" type="text" name="contact_title" value="<?php echo htmlspecialchars($contact_title); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="modern-label">Meta Title</label>
                                        <input class="modern-form-control" type="text" name="contact_meta_title" value="<?php echo htmlspecialchars($contact_meta_title); ?>">
                                    </div>             
                                    <div class="form-group">
                                        <label class="modern-label">Meta Keywords</label>
                                        <textarea class="modern-form-control" name="contact_meta_keyword" rows="3"><?php echo htmlspecialchars($contact_meta_keyword); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="modern-label">Meta Description</label>
                                        <textarea class="modern-form-control" name="contact_meta_description" rows="3"><?php echo htmlspecialchars($contact_meta_description); ?></textarea>
                                    </div>                                    
                                    <div class="form-actions">
                                        <button type="submit" class="modern-btn modern-btn-success" name="form_contact">
                                            <i class="fa fa-save"></i> Update Contact Page
                                        </button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>

        <!-- Terms & Conditions Page Content -->
        <div class="tab-pane" id="tab_tnc">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="modern-form-container">
                <div class="form-section">
                    <div class="form-group">
                        <label class="modern-label">Page Title *</label>
                        <input class="modern-form-control" type="text" name="tnc_title" value="<?php echo htmlspecialchars($tnc_title); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="modern-label">Page Content *</label>
                        <textarea class="modern-form-control" name="tnc_content" id="editor_tnc" rows="8" required><?php echo htmlspecialchars($tnc_content); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="modern-label">Meta Title</label>
                        <input class="modern-form-control" type="text" name="tnc_meta_title" value="<?php echo htmlspecialchars($tnc_meta_title); ?>">
                    </div>
                    <div class="form-group">
                        <label class="modern-label">Meta Keywords</label>
                        <textarea class="modern-form-control" name="tnc_meta_keyword" rows="3"><?php echo htmlspecialchars($tnc_meta_keyword); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="modern-label">Meta Description</label>
                        <textarea class="modern-form-control" name="tnc_meta_description" rows="3"><?php echo htmlspecialchars($tnc_meta_description); ?></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="modern-btn modern-btn-success" name="form_tnc">
                            <i class="fa fa-save"></i> Update Terms & Conditions
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <!-- Shipping & Returns Page Content -->
        <div class="tab-pane" id="tab_shipping">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="modern-form-container">
                <div class="form-section">
                    <div class="form-group">
                        <label class="modern-label">Page Title *</label>
                        <input class="modern-form-control" type="text" name="shipping_title" value="<?php echo htmlspecialchars($shipping_title); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="modern-label">Page Content *</label>
                        <textarea class="modern-form-control" name="shipping_content" id="editor_shipping" rows="8" required><?php echo htmlspecialchars($shipping_content); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="modern-label">Meta Title</label>
                        <input class="modern-form-control" type="text" name="shipping_meta_title" value="<?php echo htmlspecialchars($shipping_meta_title); ?>">
                    </div>
                    <div class="form-group">
                        <label class="modern-label">Meta Keywords</label>
                        <textarea class="modern-form-control" name="shipping_meta_keyword" rows="3"><?php echo htmlspecialchars($shipping_meta_keyword); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="modern-label">Meta Description</label>
                        <textarea class="modern-form-control" name="shipping_meta_description" rows="3"><?php echo htmlspecialchars($shipping_meta_description); ?></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="modern-btn modern-btn-success" name="form_shipping">
                            <i class="fa fa-save"></i> Update Shipping & Returns
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <!-- Privacy Policy Page Content -->
        <div class="tab-pane" id="tab_privacy">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="modern-form-container">
                <div class="form-section">
                    <div class="form-group">
                        <label class="modern-label">Page Title *</label>
                        <input class="modern-form-control" type="text" name="privacy_title" value="<?php echo htmlspecialchars($privacy_title); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="modern-label">Page Content *</label>
                        <textarea class="modern-form-control" name="privacy_content" id="editor_privacy" rows="8" required><?php echo htmlspecialchars($privacy_content); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="modern-label">Meta Title</label>
                        <input class="modern-form-control" type="text" name="privacy_meta_title" value="<?php echo htmlspecialchars($privacy_meta_title); ?>">
                    </div>
                    <div class="form-group">
                        <label class="modern-label">Meta Keywords</label>
                        <textarea class="modern-form-control" name="privacy_meta_keyword" rows="3"><?php echo htmlspecialchars($privacy_meta_keyword); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="modern-label">Meta Description</label>
                        <textarea class="modern-form-control" name="privacy_meta_description" rows="3"><?php echo htmlspecialchars($privacy_meta_description); ?></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="modern-btn modern-btn-success" name="form_privacy">
                            <i class="fa fa-save"></i> Update Privacy Policy
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </div>

        <!-- Seller T&C Page Content -->
        <div class="tab-pane" id="tab_seller_tnc">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="modern-form-container">
                <div class="form-section">
                    <div class="form-group">
                        <label class="modern-label">Page Title *</label>
                        <input class="modern-form-control" type="text" name="seller_tnc_title" value="<?php echo htmlspecialchars($seller_tnc_title); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="modern-label">Page Content *</label>
                        <textarea class="modern-form-control" name="seller_tnc_content" id="editor_seller_tnc" rows="8" required><?php echo htmlspecialchars($seller_tnc_content); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="modern-label">Meta Title</label>
                        <input class="modern-form-control" type="text" name="seller_tnc_meta_title" value="<?php echo htmlspecialchars($seller_tnc_meta_title); ?>">
                    </div>
                    <div class="form-group">
                        <label class="modern-label">Meta Keywords</label>
                        <textarea class="modern-form-control" name="seller_tnc_meta_keyword" rows="3"><?php echo htmlspecialchars($seller_tnc_meta_keyword); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="modern-label">Meta Description</label>
                        <textarea class="modern-form-control" name="seller_tnc_meta_description" rows="3"><?php echo htmlspecialchars($seller_tnc_meta_description); ?></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="modern-btn modern-btn-success" name="form_seller_tnc">
                            <i class="fa fa-save"></i> Update Seller T&C
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </div>



                

            </form>
        </div>
    </div>

</section>

<?php require_once('footer.php'); ?>
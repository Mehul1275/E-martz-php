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
    margin-bottom: 2rem;
}

.modern-tabs-nav {
    background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
    border-bottom: 2px solid #e3e6f0;
    padding: 0;
    margin: 0;
    display: flex;
    flex-wrap: wrap;
}

.modern-tab-btn {
    background: none;
    border: none;
    padding: 1rem 1.5rem;
    color: #5a5c69;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

.modern-tab-btn:hover {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
}

.modern-tab-btn.active {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    font-weight: 600;
}

.modern-tabs-content {
    background: white;
}

.modern-tab-pane {
    display: none;
    padding: 2rem;
}

.modern-tab-pane.active {
    display: block;
}

.tab-header {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e3e6f0;
}

.tab-header h3 {
    margin: 0 0 0.5rem 0;
    color: #2c3e50;
    font-size: 1.5rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.tab-header p {
    margin: 0;
    color: #7f8c8d;
    font-size: 1rem;
}

.settings-section {
    margin-bottom: 2rem;
    background: #f8f9fc;
    border-radius: 8px;
    padding: 1.5rem;
    border: 1px solid #e3e6f0;
}

.settings-section h4 {
    margin: 0 0 1rem 0;
    color: #2c3e50;
    font-size: 1.2rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-card {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    border: 1px solid #e3e6f0;
}

.form-row {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.form-group {
    flex: 1;
    min-width: 250px;
}

.form-label {
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

.modern-textarea {
    resize: vertical;
    min-height: 100px;
}

.form-text {
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 0.25rem;
    line-height: 1.4;
}

.form-actions {
    margin-top: 1.5rem;
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

.modern-btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.modern-btn-primary:hover {
    background: linear-gradient(135deg, #5a67d8, #6b46c1);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
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

.modern-alert {
    border-radius: 8px;
    border: none;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.modern-alert-success {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    color: #155724;
    border-left: 4px solid #28a745;
}

.modern-alert-danger {
    background: linear-gradient(135deg, #f8d7da, #f5c6cb);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

.alert-content {
    flex: 1;
}

.alert-content strong {
    display: block;
    margin-bottom: 0.25rem;
}

.logo-preview, .favicon-preview {
    padding: 1rem;
    background: #f8f9fc;
    border: 2px dashed #e3e6f0;
    border-radius: 8px;
    text-align: center;
}

.current-logo {
    max-width: 200px;
    max-height: 80px;
    border-radius: 4px;
}

.current-favicon {
    width: 32px;
    height: 32px;
    border-radius: 4px;
}

.file-upload-wrapper {
    position: relative;
    border: 2px dashed #e3e6f0;
    border-radius: 8px;
    padding: 2rem;
    text-align: center;
    background: #f8f9fc;
    transition: all 0.3s ease;
}

.file-upload-wrapper:hover {
    border-color: #667eea;
    background: rgba(102, 126, 234, 0.05);
}

.modern-file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.file-upload-info {
    pointer-events: none;
    color: #5a5c69;
}

.file-upload-info i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    color: #667eea;
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

/* Responsive design */
@media (max-width: 768px) {
    .modern-tabs-nav {
        flex-direction: column;
    }
    
    .modern-tab-btn {
        padding: 0.75rem 1rem;
    }
    
    .modern-tab-pane {
        padding: 1rem;
    }
    
    .form-row {
        flex-direction: column;
    }
    
    .form-group {
        min-width: auto;
    }
}
</style>

<?php
//Change Logo
if(isset($_POST['form1'])) {
    $valid = 1;

    $path = $_FILES['photo_logo']['name'];
    $path_tmp = $_FILES['photo_logo']['tmp_name'];

    if($path == '') {
        $valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {
        // removing the existing photo
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
        foreach ($result as $row) {
            $logo = $row['logo'];
            unlink('../assets/uploads/'.$logo);
        }

        // updating the data
        $final_name = 'logo'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET logo=? WHERE id=1");
        $statement->execute(array($final_name));

        $success_message = 'Logo is updated successfully.';
        
    }
}
// Change Favicon
if(isset($_POST['form2'])) {
    $valid = 1;

    $path = $_FILES['photo_favicon']['name'];
    $path_tmp = $_FILES['photo_favicon']['tmp_name'];

    if($path == '') {
        $valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {
        // removing the existing photo
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
        foreach ($result as $row) {
            $favicon = $row['favicon'];
            unlink('../assets/uploads/'.$favicon);
        }

        // updating the data
        $final_name = 'favicon'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET favicon=? WHERE id=1");
        $statement->execute(array($final_name));

        $success_message = 'Favicon is updated successfully.';
        
    }
}
//Footer & Contact us page
if(isset($_POST['form3'])) {
    
    // updating the database
    $statement = $pdo->prepare("UPDATE tbl_settings SET newsletter_on_off=?, footer_copyright=?, contact_address=?, contact_email=?, contact_phone=?, contact_map_iframe=? WHERE id=1");
    $statement->execute(array($_POST['newsletter_on_off'],$_POST['footer_copyright'],$_POST['contact_address'],$_POST['contact_email'],$_POST['contact_phone'],$_POST['contact_map_iframe']));

    $success_message = 'General content settings is updated successfully.';
    
}
//Email Settings
if(isset($_POST['form4'])) {
    // updating the database
    $statement = $pdo->prepare("UPDATE tbl_settings SET receive_email=?, receive_email_subject=?,receive_email_thank_you_message=?, forget_password_message=? WHERE id=1");
    $statement->execute(array($_POST['receive_email'],$_POST['receive_email_subject'],$_POST['receive_email_thank_you_message'],$_POST['forget_password_message']));

    $success_message = 'Contact form settings information is updated successfully.';
}

//Can not finish this section, leave it
if(isset($_POST['form5'])) {
    // updating the database
    $statement = $pdo->prepare("UPDATE tbl_settings SET total_featured_product_home=?, total_latest_product_home=?, total_popular_product_home=? WHERE id=1");
    $statement->execute(array($_POST['total_featured_product_home'],$_POST['total_latest_product_home'],$_POST['total_popular_product_home']));

    $success_message = 'Sidebar settings is updated successfully.';
}


if(isset($_POST['form6_0'])) {
    // updating the database
    $statement = $pdo->prepare("UPDATE tbl_settings SET home_service_on_off=?, home_welcome_on_off=?, home_featured_product_on_off=?, home_latest_product_on_off=?, home_popular_product_on_off=? WHERE id=1");
    $statement->execute(array($_POST['home_service_on_off'],$_POST['home_welcome_on_off'],$_POST['home_featured_product_on_off'],$_POST['home_latest_product_on_off'],$_POST['home_popular_product_on_off']));

    $success_message = 'Section On-Off Settings is updated successfully.';
}


if(isset($_POST['form6'])) {
    // updating the database
    $statement = $pdo->prepare("UPDATE tbl_settings SET meta_title_home=?, meta_keyword_home=?, meta_description_home=? WHERE id=1");
    $statement->execute(array($_POST['meta_title_home'],$_POST['meta_keyword_home'],$_POST['meta_description_home']));

    $success_message = 'Home Meta settings is updated successfully.';
}

if(isset($_POST['form6_7'])) {

    $valid = 1;

    if(empty($_POST['cta_title'])) {
        $valid = 0;
        $error_message .= 'Call to Action Title can not be empty<br>';
    }

    if(empty($_POST['cta_content'])) {
        $valid = 0;
        $error_message .= 'Call to Action Content can not be empty<br>';
    }

    if(empty($_POST['cta_read_more_text'])) {
        $valid = 0;
        $error_message .= 'Call to Action Read More Text can not be empty<br>';
    }

    if(empty($_POST['cta_read_more_url'])) {
        $valid = 0;
        $error_message .= 'Call to Action Read More URL can not be empty<br>';
    }

    $path = $_FILES['cta_photo']['name'];
    $path_tmp = $_FILES['cta_photo']['tmp_name'];

    if($path != '') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {

        if($path != '') {
            // removing the existing photo
            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $cta_photo = $row['cta_photo'];
                unlink('../assets/uploads/'.$cta_photo);
            }

            // updating the data
            $final_name = 'cta'.'.'.$ext;
            move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET cta_title=?,cta_content=?,cta_read_more_text=?,cta_read_more_url=?,cta_photo=? WHERE id=1");
            $statement->execute(array($_POST['cta_title'],$_POST['cta_content'],$_POST['cta_read_more_text'],$_POST['cta_read_more_url'],$final_name));
        } else {
            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET cta_title=?,cta_content=?,cta_read_more_text=?,cta_read_more_url=? WHERE id=1");
            $statement->execute(array($_POST['cta_title'],$_POST['cta_content'],$_POST['cta_read_more_text'],$_POST['cta_read_more_url']));
        }

        $success_message = 'Call to Action Data is updated successfully.';
        
    }
}

if(isset($_POST['form6_4'])) {

    $valid = 1;

    if(empty($_POST['featured_product_title'])) {
        $valid = 0;
        $error_message .= 'Featured Product Title can not be empty<br>';
    }

    if(empty($_POST['featured_product_subtitle'])) {
        $valid = 0;
        $error_message .= 'Featured Product SubTitle can not be empty<br>';
    }

    if($valid == 1) {

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET featured_product_title=?,featured_product_subtitle=? WHERE id=1");
        $statement->execute(array($_POST['featured_product_title'],$_POST['featured_product_subtitle']));

        $success_message = 'Featured Product Data is updated successfully.';
        
    }
}

if(isset($_POST['form6_5'])) {

    $valid = 1;

    if(empty($_POST['latest_product_title'])) {
        $valid = 0;
        $error_message .= 'Latest Product Title can not be empty<br>';
    }

    if(empty($_POST['latest_product_subtitle'])) {
        $valid = 0;
        $error_message .= 'Latest Product SubTitle can not be empty<br>';
    }

    if($valid == 1) {

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET latest_product_title=?,latest_product_subtitle=? WHERE id=1");
        $statement->execute(array($_POST['latest_product_title'],$_POST['latest_product_subtitle']));

        $success_message = 'Latest Product Data is updated successfully.';
        
    }
}

if(isset($_POST['form6_6'])) {

    $valid = 1;

    if(empty($_POST['popular_product_title'])) {
        $valid = 0;
        $error_message .= 'Popular Product Title can not be empty<br>';
    }

    if(empty($_POST['popular_product_subtitle'])) {
        $valid = 0;
        $error_message .= 'Popular Product SubTitle can not be empty<br>';
    }

    if($valid == 1) {

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET popular_product_title=?,popular_product_subtitle=? WHERE id=1");
        $statement->execute(array($_POST['popular_product_title'],$_POST['popular_product_subtitle']));

        $success_message = 'Popular Product Data is updated successfully.';
        
    }
}
/*
if(isset($_POST['form6_1'])) {

    $valid = 1;

    if(empty($_POST['testimonial_title'])) {
        $valid = 0;
        $error_message .= 'Testimonial Title can not be empty<br>';
    }

    if(empty($_POST['testimonial_subtitle'])) {
        $valid = 0;
        $error_message .= 'Testimonial SubTitle can not be empty<br>';
    }

    $path = $_FILES['testimonial_photo']['name'];
    $path_tmp = $_FILES['testimonial_photo']['tmp_name'];

    if($path != '') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {


        if($path != '') {
            // removing the existing photo
            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $testimonial_photo = $row['testimonial_photo'];
                unlink('../assets/uploads/'.$testimonial_photo);
            }

            // updating the data
            $final_name = 'testimonial'.'.'.$ext;
            move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET testimonial_title=?,testimonial_subtitle=?, testimonial_photo=? WHERE id=1");
            $statement->execute(array($_POST['testimonial_title'],$_POST['testimonial_subtitle'],$final_name));
        } else {
            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET testimonial_title=?,testimonial_subtitle=? WHERE id=1");
            $statement->execute(array($_POST['testimonial_title'],$_POST['testimonial_subtitle']));
        }

        $success_message = 'Testimonial Data is updated successfully.';
        
    }
}


if(isset($_POST['form6_2'])) {

    $valid = 1;

    if(empty($_POST['blog_title'])) {
        $valid = 0;
        $error_message .= 'Blog Title can not be empty<br>';
    }

    if(empty($_POST['blog_subtitle'])) {
        $valid = 0;
        $error_message .= 'Blog SubTitle can not be empty<br>';
    }

    if($valid == 1) {

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET blog_title=?,blog_subtitle=? WHERE id=1");
        $statement->execute(array($_POST['blog_title'],$_POST['blog_subtitle']));

        $success_message = 'Blog Data is updated successfully.';
        
    }
}
*/

if(isset($_POST['form6_3'])) {

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET newsletter_text=? WHERE id=1");
        $statement->execute(array($_POST['newsletter_text']));
        
        $success_message = 'Newsletter Text is updated successfully.';
 
}

// Removed: All Banner upload handlers and seller banner handlers


if(isset($_POST['form10'])) {
    // updating the database
    $statement = $pdo->prepare("UPDATE tbl_settings SET before_head=?, after_body=?, before_body=? WHERE id=1");
    $statement->execute(array($_POST['before_head'],$_POST['after_body'],$_POST['before_body']));

    $success_message = 'Head and Body Script is updated successfully.';
}

/*
if(isset($_POST['form11'])) {
    // updating the database
    $statement = $pdo->prepare("UPDATE tbl_settings 
    					SET 
    					ads_above_welcome_on_off=?, 
    					ads_above_featured_product_on_off=?, 
    					ads_above_latest_product_on_off=?, 
    					ads_above_popular_product_on_off=?, 
    					ads_above_testimonial_on_off=?, 
    					ads_category_sidebar_on_off=? 

    					WHERE id=1");
    $statement->execute(array(
    					$_POST['ads_above_welcome_on_off'],
    					$_POST['ads_above_featured_product_on_off'],
    					$_POST['ads_above_latest_product_on_off'],
    					$_POST['ads_above_popular_product_on_off'],
    					$_POST['ads_above_testimonial_on_off'],
    					$_POST['ads_category_sidebar_on_off']
					));

    $success_message = 'Advertisement On-Off Section is updated successfully.';
} */
?>


<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
foreach ($result as $row) {
    $logo                            = $row['logo'];
    $favicon                         = $row['favicon'];
    $footer_about                    = $row['footer_about'];
    $footer_copyright                = $row['footer_copyright'];
    $contact_address                 = $row['contact_address'];
    $contact_email                   = $row['contact_email'];
    $contact_phone                   = $row['contact_phone'];
   // $contact_fax                     = $row['contact_fax'];
    $contact_map_iframe              = $row['contact_map_iframe'];
    $receive_email                   = $row['receive_email'];
    $receive_email_subject           = $row['receive_email_subject'];
    $receive_email_thank_you_message = $row['receive_email_thank_you_message'];
    $forget_password_message         = $row['forget_password_message'];
   // $total_recent_post_footer        = $row['total_recent_post_footer'];
   // $total_popular_post_footer       = $row['total_popular_post_footer'];
  //  $total_recent_post_sidebar       = $row['total_recent_post_sidebar'];
  //  $total_popular_post_sidebar      = $row['total_popular_post_sidebar'];
    $total_featured_product_home     = $row['total_featured_product_home'];
    $total_latest_product_home       = $row['total_latest_product_home'];
    $total_popular_product_home      = $row['total_popular_product_home'];
    $meta_title_home                 = $row['meta_title_home'];
    $meta_keyword_home               = $row['meta_keyword_home'];
    $meta_description_home           = $row['meta_description_home'];
   // Removed: banner_* fields no longer used
   // $cta_title                       = $row['cta_title'];
   // $cta_content                     = $row['cta_content'];
   // $cta_read_more_text              = $row['cta_read_more_text'];
  //  $cta_read_more_url               = $row['cta_read_more_url'];
  //  $cta_photo                       = $row['cta_photo'];
    $featured_product_title          = $row['featured_product_title'];
    $featured_product_subtitle       = $row['featured_product_subtitle'];
    $latest_product_title            = $row['latest_product_title'];
    $latest_product_subtitle         = $row['latest_product_subtitle'];
    $popular_product_title           = $row['popular_product_title'];
    $popular_product_subtitle        = $row['popular_product_subtitle'];
   // $testimonial_title               = $row['testimonial_title'];
   // $testimonial_subtitle            = $row['testimonial_subtitle'];
  //  $testimonial_photo               = $row['testimonial_photo'];
  //  $blog_title                      = $row['blog_title'];
   // $blog_subtitle                   = $row['blog_subtitle'];
    $newsletter_text                 = $row['newsletter_text'];
    $paypal_email                    = $row['paypal_email'];
  //  $stripe_public_key               = $row['stripe_public_key'];
 //   $stripe_secret_key               = $row['stripe_secret_key'];
    $bank_detail                     = $row['bank_detail'];
    $before_head                     = $row['before_head'];
    $after_body                      = $row['after_body'];
    $before_body                     = $row['before_body'];
    $home_service_on_off             = $row['home_service_on_off'];
    $home_welcome_on_off             = $row['home_welcome_on_off'];
    $home_featured_product_on_off    = $row['home_featured_product_on_off'];
    $home_latest_product_on_off      = $row['home_latest_product_on_off'];
    $home_popular_product_on_off     = $row['home_popular_product_on_off'];
  //  $home_testimonial_on_off         = $row['home_testimonial_on_off'];
   // $home_blog_on_off                = $row['home_blog_on_off'];
    $newsletter_on_off               = $row['newsletter_on_off'];
  //  $ads_above_welcome_on_off           = $row['ads_above_welcome_on_off'];
  //  $ads_above_featured_product_on_off  = $row['ads_above_featured_product_on_off'];
  //  $ads_above_latest_product_on_off    = $row['ads_above_latest_product_on_off'];
  //  $ads_above_popular_product_on_off   = $row['ads_above_popular_product_on_off'];
  //  $ads_above_testimonial_on_off       = $row['ads_above_testimonial_on_off'];
  //  $ads_category_sidebar_on_off        = $row['ads_category_sidebar_on_off'];
}
?>


<!-- Modern Page Header -->
<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-cogs"></i>
        Website Settings
    </h1>
    <div class="subtitle">Configure your website's core settings and preferences</div>
</div>

<div class="modern-container slide-in">
    <?php if($error_message): ?>
    <div class="modern-alert modern-alert-danger">
        <i class="fa fa-exclamation-triangle"></i>
        <div class="alert-content">
            <strong>Error!</strong>
            <p><?php echo $error_message; ?></p>
        </div>
    </div>
    <?php endif; ?>

    <?php if($success_message): ?>
    <div class="modern-alert modern-alert-success">
        <i class="fa fa-check-circle"></i>
        <div class="alert-content">
            <strong>Success!</strong>
            <p><?php echo $success_message; ?></p>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="modern-container">
    <div class="modern-tabs-container">
        <div class="modern-tabs-nav">
            <button class="modern-tab-btn active" data-tab="tab_1">
                <i class="fa fa-image"></i> Logo
            </button>
            <button class="modern-tab-btn" data-tab="tab_2">
                <i class="fa fa-star"></i> Favicon
            </button>
            <button class="modern-tab-btn" data-tab="tab_3">
                <i class="fa fa-address-card"></i> Footer & Contact
            </button>
            <button class="modern-tab-btn" data-tab="tab_4">
                <i class="fa fa-envelope"></i> Message Settings
            </button>
            <button class="modern-tab-btn" data-tab="tab_5">
                <i class="fa fa-cube"></i> Products
            </button>
            <button class="modern-tab-btn" data-tab="tab_6">
                <i class="fa fa-home"></i> Home Settings
            </button>
            <button class="modern-tab-btn" data-tab="tab_10">
                <i class="fa fa-code"></i> Scripts
            </button>
        </div>
        <div class="modern-tabs-content">
            <div class="modern-tab-pane active" id="tab_1">
                <div class="tab-header">
                    <h3><i class="fa fa-image"></i> Logo Settings</h3>
                    <p>Upload and manage your website logo</p>
                </div>


                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Current Logo</label>
                                <div class="logo-preview">
                                    <img src="../assets/uploads/<?php echo $logo; ?>" class="current-logo" alt="Current Logo">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Upload New Logo</label>
                                <div class="file-upload-wrapper">
                                    <input type="file" name="photo_logo" class="modern-file-input" accept=".jpg,.jpeg,.png,.gif">
                                    <div class="file-upload-info">
                                        <i class="fa fa-cloud-upload"></i>
                                        <span>Choose logo file (JPG, PNG, GIF)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="modern-btn modern-btn-primary" name="form1">
                                <i class="fa fa-save"></i> Update Logo
                            </button>
                        </div>
                                </div>
                            </div>
                            </form>

                            


            </div>
            <div class="modern-tab-pane" id="tab_2">
                <div class="tab-header">
                    <h3><i class="fa fa-star"></i> Favicon Settings</h3>
                    <p>Upload and manage your website favicon</p>
                </div>

                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Current Favicon</label>
                                <div class="favicon-preview">
                                    <img src="../assets/uploads/<?php echo $favicon; ?>" class="current-favicon" alt="Current Favicon">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Upload New Favicon</label>
                                <div class="file-upload-wrapper">
                                    <input type="file" name="photo_favicon" class="modern-file-input" accept=".jpg,.jpeg,.png,.gif">
                                    <div class="file-upload-info">
                                        <i class="fa fa-cloud-upload"></i>
                                        <span>Choose favicon file (JPG, PNG, GIF)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="modern-btn modern-btn-primary" name="form2">
                                <i class="fa fa-save"></i> Update Favicon
                            </button>
                        </div>
                                </div>
                            </div>
                            </form>


            </div>
            <div class="modern-tab-pane" id="tab_3">
                <div class="tab-header">
                    <h3><i class="fa fa-address-card"></i> Footer & Contact Settings</h3>
                    <p>Configure footer content and contact information</p>
                </div>

                <!-- Newsletter Settings -->
                <div class="settings-section">
                    <h4><i class="fa fa-envelope"></i> Newsletter Configuration</h4>
                    <form class="modern-form" action="" method="post">
                        <div class="form-card">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Newsletter Section Status</label>
                                    <select name="newsletter_on_off" class="modern-form-control">
                                        <option value="1" <?php if($newsletter_on_off == 1) {echo 'selected';} ?>>Enable Newsletter</option>
                                        <option value="0" <?php if($newsletter_on_off == 0) {echo 'selected';} ?>>Disable Newsletter</option>
                                    </select>
                                    <small class="form-text">Enable or disable the newsletter subscription section on your website</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer Settings -->
                <div class="settings-section">
                    <h4><i class="fa fa-copyright"></i> Footer Information</h4>
                    <form class="modern-form" action="" method="post">
                        <div class="form-card">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Copyright Text</label>
                                    <input class="modern-form-control" type="text" name="footer_copyright" value="<?php echo htmlspecialchars($footer_copyright); ?>" placeholder="© 2024 Your Company Name. All rights reserved.">
                                    <small class="form-text">This text will appear in the footer of your website</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="settings-section">
                    <h4><i class="fa fa-phone"></i> Contact Information</h4>
                    <form class="modern-form" action="" method="post">
                        <div class="form-card">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Business Address</label>
                                    <textarea class="modern-form-control modern-textarea" name="contact_address" placeholder="Enter your complete business address"><?php echo htmlspecialchars($contact_address); ?></textarea>
                                    <small class="form-text">Your business address for customer contact</small>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Contact Email</label>
                                    <input type="email" class="modern-form-control" name="contact_email" value="<?php echo htmlspecialchars($contact_email); ?>" placeholder="contact@yourcompany.com">
                                    <small class="form-text">Primary email address for customer inquiries</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" class="modern-form-control" name="contact_phone" value="<?php echo htmlspecialchars($contact_phone); ?>" placeholder="+1 (555) 123-4567">
                                    <small class="form-text">Primary phone number for customer support</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Map Integration -->
                <div class="settings-section">
                    <h4><i class="fa fa-map-marker"></i> Location Map</h4>
                    <form class="modern-form" action="" method="post">
                        <div class="form-card">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Google Maps Embed Code</label>
                                    <textarea class="modern-form-control modern-textarea" name="contact_map_iframe" placeholder="Paste your Google Maps embed iframe code here" style="min-height: 150px;"><?php echo htmlspecialchars($contact_map_iframe); ?></textarea>
                                    <small class="form-text">
                                        <strong>How to get embed code:</strong><br>
                                        1. Go to <a href="https://maps.google.com" target="_blank">Google Maps</a><br>
                                        2. Search for your business location<br>
                                        3. Click "Share" → "Embed a map"<br>
                                        4. Copy the iframe code and paste it here
                                    </small>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="modern-btn modern-btn-primary" name="form3">
                                    <i class="fa fa-save"></i> Update Footer & Contact Settings
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modern-tab-pane" id="tab_4">
                <div class="tab-header">
                    <h3><i class="fa fa-envelope"></i> Message Settings</h3>
                    <p>Configure email settings and messages</p>
                </div>

                <form class="modern-form" action="" method="post">
                    <div class="form-card">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Contact Email Address</label>
                                <input type="email" class="modern-form-control" name="receive_email" value="<?php echo htmlspecialchars($receive_email); ?>" placeholder="Enter contact email">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Contact Email Subject</label>
                                <input type="text" class="modern-form-control" name="receive_email_subject" value="<?php echo htmlspecialchars($receive_email_subject); ?>" placeholder="Enter email subject">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Thank You Message</label>
                                <textarea class="modern-form-control modern-textarea" name="receive_email_thank_you_message" placeholder="Enter thank you message for contact form submissions"><?php echo htmlspecialchars($receive_email_thank_you_message); ?></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Forget Password Message</label>
                                <textarea class="modern-form-control modern-textarea" name="forget_password_message" placeholder="Enter forget password message"><?php echo htmlspecialchars($forget_password_message); ?></textarea>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="modern-btn modern-btn-primary" name="form4">
                                <i class="fa fa-save"></i> Update Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modern-tab-pane" id="tab_5">
                <div class="tab-header">
                    <h3><i class="fa fa-cube"></i> Product Settings</h3>
                    <p>Configure product display settings</p>
                </div>

                <form class="modern-form" action="" method="post">
                    <div class="form-card">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Featured Products on Home <span class="required">*</span></label>
                                <input type="number" class="modern-form-control" name="total_featured_product_home" value="<?php echo htmlspecialchars($total_featured_product_home); ?>" placeholder="Number of featured products">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Latest Products on Home <span class="required">*</span></label>
                                <input type="number" class="modern-form-control" name="total_latest_product_home" value="<?php echo htmlspecialchars($total_latest_product_home); ?>" placeholder="Number of latest products">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Popular Products on Home <span class="required">*</span></label>
                                <input type="number" class="modern-form-control" name="total_popular_product_home" value="<?php echo htmlspecialchars($total_popular_product_home); ?>" placeholder="Number of popular products">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="modern-btn modern-btn-primary" name="form5">
                                <i class="fa fa-save"></i> Update Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modern-tab-pane" id="tab_6">
                <div class="tab-header">
                    <h3><i class="fa fa-home"></i> Home Settings</h3>
                    <p>Configure home page sections and content</p>
                </div>

                <!-- Section On/Off Settings -->
                <div class="settings-section">
                    <h4><i class="fa fa-toggle-on"></i> Section Visibility</h4>
                    <form class="modern-form" action="" method="post">
                        <div class="form-card">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Service Section</label>
                                    <select name="home_service_on_off" class="modern-form-control">
                                        <option value="1" <?php if($home_service_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if($home_service_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Welcome Section</label>
                                    <select name="home_welcome_on_off" class="modern-form-control">
                                        <option value="1" <?php if($home_welcome_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if($home_welcome_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Featured Product Section</label>
                                    <select name="home_featured_product_on_off" class="modern-form-control">
                                        <option value="1" <?php if($home_featured_product_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if($home_featured_product_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Latest Product Section</label>
                                    <select name="home_latest_product_on_off" class="modern-form-control">
                                        <option value="1" <?php if($home_latest_product_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if($home_latest_product_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Popular Product Section</label>
                                    <select name="home_popular_product_on_off" class="modern-form-control">
                                        <option value="1" <?php if($home_popular_product_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if($home_popular_product_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="modern-btn modern-btn-primary" name="form6_0">
                                    <i class="fa fa-save"></i> Update Sections
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                
                <!-- Meta Settings -->
                <div class="settings-section">
                    <h4><i class="fa fa-search"></i> SEO Meta Settings</h4>
                    <form class="modern-form" action="" method="post">
                        <div class="form-card">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title_home" class="modern-form-control" value="<?php echo htmlspecialchars($meta_title_home); ?>" placeholder="Enter meta title for home page">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Meta Keywords</label>
                                    <textarea class="modern-form-control modern-textarea" name="meta_keyword_home" placeholder="Enter comma-separated keywords"><?php echo htmlspecialchars($meta_keyword_home); ?></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Meta Description</label>
                                    <textarea class="modern-form-control modern-textarea" name="meta_description_home" placeholder="Enter meta description for home page"><?php echo htmlspecialchars($meta_description_home); ?></textarea>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="modern-btn modern-btn-primary" name="form6">
                                    <i class="fa fa-save"></i> Update Meta Settings
                                </button>
                            </div>
                        </div>
                    </form>
                </div>



                           <!-- <h3>Call to Action Section</h3>
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">                                          
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Title<span>*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="cta_title" value="<?php echo $cta_title; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Content<span>*</span></label>
                                        <div class="col-sm-8">
                                            <textarea name="cta_content" class="form-control" cols="30" rows="10" style="height:120px;">&<?php echo $cta_content; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Read More Text<span>*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="cta_read_more_text" value="<?php echo $cta_read_more_text; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Read More URL<span>*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="cta_read_more_url" value="<?php echo $cta_read_more_url; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Existing Call to Action Background</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <img src="../assets/uploads/<?php echo $cta_photo; ?>" class="existing-photo" style="height:80px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">New Background</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <input type="file" name="cta_photo">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form6_7">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>-->





                <!-- Featured Product Section -->
                <div class="settings-section">
                    <h4><i class="fa fa-star"></i> Featured Product Section</h4>
                    <form class="modern-form" action="" method="post">
                        <div class="form-card">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Featured Product Title <span class="required">*</span></label>
                                    <input type="text" class="modern-form-control" name="featured_product_title" value="<?php echo htmlspecialchars($featured_product_title); ?>" placeholder="Enter featured products title">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Featured Product Subtitle <span class="required">*</span></label>
                                    <input type="text" class="modern-form-control" name="featured_product_subtitle" value="<?php echo htmlspecialchars($featured_product_subtitle); ?>" placeholder="Enter featured products subtitle">
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="modern-btn modern-btn-primary" name="form6_4">
                                    <i class="fa fa-save"></i> Update Featured Products
                                </button>
                            </div>
                        </div>
                    </form>
                </div>


                <!-- Latest Product Section -->
                <div class="settings-section">
                    <h4><i class="fa fa-clock-o"></i> Latest Product Section</h4>
                    <form class="modern-form" action="" method="post">
                        <div class="form-card">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Latest Product Title <span class="required">*</span></label>
                                    <input type="text" class="modern-form-control" name="latest_product_title" value="<?php echo htmlspecialchars($latest_product_title); ?>" placeholder="Enter latest products title">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Latest Product Subtitle <span class="required">*</span></label>
                                    <input type="text" class="modern-form-control" name="latest_product_subtitle" value="<?php echo htmlspecialchars($latest_product_subtitle); ?>" placeholder="Enter latest products subtitle">
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="modern-btn modern-btn-primary" name="form6_5">
                                    <i class="fa fa-save"></i> Update Latest Products
                                </button>
                            </div>
                        </div>
                    </form>
                </div>


                <!-- Popular Product Section -->
                <div class="settings-section">
                    <h4><i class="fa fa-fire"></i> Popular Product Section</h4>
                    <form class="modern-form" action="" method="post">
                        <div class="form-card">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Popular Product Title <span class="required">*</span></label>
                                    <input type="text" class="modern-form-control" name="popular_product_title" value="<?php echo htmlspecialchars($popular_product_title); ?>" placeholder="Enter popular products title">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Popular Product Subtitle <span class="required">*</span></label>
                                    <input type="text" class="modern-form-control" name="popular_product_subtitle" value="<?php echo htmlspecialchars($popular_product_subtitle); ?>" placeholder="Enter popular products subtitle">
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="modern-btn modern-btn-primary" name="form6_6">
                                    <i class="fa fa-save"></i> Update Popular Products
                                </button>
                            </div>
                        </div>
                    </form>
                </div>


                            <!--
                            <h3>Testimonial Section</h3>
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">                                          
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Testimonial Section Title<span>*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="testimonial_title" value="<?php echo $testimonial_title; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Testimonial Section SubTitle<span>*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="testimonial_subtitle" value="<?php echo $testimonial_subtitle; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Existing Testimonial Background</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <img src="../assets/uploads/<?php echo $testimonial_photo; ?>" class="existing-photo" style="height:80px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">New Background</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <input type="file" name="testimonial_photo">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form6_1">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>


                            <h3>Blog Section</h3>
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">                                          
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Blog Section Title<span>*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="blog_title" value="<?php echo $blog_title; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Blog Section SubTitle<span>*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="blog_subtitle" value="<?php echo $blog_subtitle; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form6_2">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>

                                    -->
                            

                <!-- Newsletter Section -->
                <div class="settings-section">
                    <h4><i class="fa fa-envelope-o"></i> Newsletter Section</h4>
                    <form class="modern-form" action="" method="post">
                        <div class="form-card">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Newsletter Text</label>
                                    <textarea name="newsletter_text" class="modern-form-control modern-textarea" placeholder="Enter newsletter subscription text"><?php echo htmlspecialchars($newsletter_text); ?></textarea>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="modern-btn modern-btn-primary" name="form6_3">
                                    <i class="fa fa-save"></i> Update Newsletter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>


                        </div>
            </div>
            <div class="modern-tab-pane" id="tab_10">
                <div class="tab-header">
                    <h3><i class="fa fa-code"></i> Scripts Settings</h3>
                    <p>Add custom scripts and tracking codes</p>
                </div>

                <form class="modern-form" action="" method="post">
                    <div class="form-card">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Code before &lt;/head&gt; tag</label>
                                <textarea class="modern-form-control modern-textarea" name="before_head" placeholder="Add scripts, meta tags, or CSS here"><?php echo htmlspecialchars($before_head); ?></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Code after &lt;body&gt; tag</label>
                                <textarea class="modern-form-control modern-textarea" name="after_body" placeholder="Add tracking codes or scripts here"><?php echo htmlspecialchars($after_body); ?></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Code before &lt;/body&gt; tag</label>
                                <textarea class="modern-form-control modern-textarea" name="before_body" placeholder="Add JavaScript or analytics codes here"><?php echo htmlspecialchars($before_body); ?></textarea>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="modern-btn modern-btn-primary" name="form10">
                                <i class="fa fa-save"></i> Update Scripts
                            </button>
                        </div>
                    </div>
                </form>
            </div>


<!--
                        <div class="tab-pane" id="tab_11">
                            <h3>Advertisements On and Off</h3>
                            <form class="form-horizontal" action="" method="post">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Above Welcome </label>
                                        <div class="col-sm-4">
                                            <select name="ads_above_welcome_on_off" class="form-control" style="width:auto;">
                                            	<option value="1" <?php if($ads_above_welcome_on_off == 1) {echo 'selected';} ?>>On</option>
                                            	<option value="0" <?php if($ads_above_welcome_on_off == 0) {echo 'selected';} ?>>Off</option>
                                            </select>
                                        </div>
                                    </div>      
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Above Featured Product </label>
                                        <div class="col-sm-4">
                                            <select name="ads_above_featured_product_on_off" class="form-control" style="width:auto;">
                                            	<option value="1" <?php if($ads_above_featured_product_on_off == 1) {echo 'selected';} ?>>On</option>
                                            	<option value="0" <?php if($ads_above_featured_product_on_off == 0) {echo 'selected';} ?>>Off</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Above Latest Product </label>
                                        <div class="col-sm-4">
                                            <select name="ads_above_latest_product_on_off" class="form-control" style="width:auto;">
                                            	<option value="1" <?php if($ads_above_latest_product_on_off == 1) {echo 'selected';} ?>>On</option>
                                            	<option value="0" <?php if($ads_above_latest_product_on_off == 0) {echo 'selected';} ?>>Off</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Above Popular Product </label>
                                        <div class="col-sm-4">
                                            <select name="ads_above_popular_product_on_off" class="form-control" style="width:auto;">
                                            	<option value="1" <?php if($ads_above_popular_product_on_off == 1) {echo 'selected';} ?>>On</option>
                                            	<option value="0" <?php if($ads_above_popular_product_on_off == 0) {echo 'selected';} ?>>Off</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Above Testimonial </label>
                                        <div class="col-sm-4">
                                            <select name="ads_above_testimonial_on_off" class="form-control" style="width:auto;">
                                            	<option value="1" <?php if($ads_above_testimonial_on_off == 1) {echo 'selected';} ?>>On</option>
                                            	<option value="0" <?php if($ads_above_testimonial_on_off == 0) {echo 'selected';} ?>>Off</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Category Page Sidebar </label>
                                        <div class="col-sm-4">
                                            <select name="ads_category_sidebar_on_off" class="form-control" style="width:auto;">
                                            	<option value="1" <?php if($ads_category_sidebar_on_off == 1) {echo 'selected';} ?>>On</option>
                                            	<option value="0" <?php if($ads_category_sidebar_on_off == 0) {echo 'selected';} ?>>Off</option>
                                            </select>
                                        </div>
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form11">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>

-->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.modern-page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
    border-radius: 10px;
}

.page-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.page-title h1 {
    margin: 0;
    font-size: 2.5rem;
    font-weight: 600;
}

.page-subtitle {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 1.1rem;
}

.page-icon {
    font-size: 2rem;
    margin-right: 1rem;
    vertical-align: middle;
}

.modern-tabs-container {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.modern-tabs-nav {
    display: flex;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    overflow-x: auto;
}

.modern-tab-btn {
    background: none;
    border: none;
    padding: 1rem 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
    font-size: 0.95rem;
    color: #6c757d;
    border-bottom: 3px solid transparent;
}

.modern-tab-btn:hover {
    background: #e9ecef;
    color: #495057;
}

.modern-tab-btn.active {
    background: white;
    color: #007bff;
    border-bottom-color: #007bff;
    font-weight: 600;
}

.modern-tab-btn i {
    margin-right: 0.5rem;
}

.modern-tabs-content {
    padding: 2rem;
}

.modern-tab-pane {
    display: none;
}

.modern-tab-pane.active {
    display: block;
}

.tab-header {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e9ecef;
}

.tab-header h3 {
    margin: 0 0 0.5rem 0;
    color: #495057;
    font-size: 1.5rem;
}

.tab-header p {
    margin: 0;
    color: #6c757d;
    font-size: 1rem;
}

.form-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    border: 1px solid #e9ecef;
}

.settings-section {
    margin-bottom: 2rem;
}

.settings-section h4 {
    color: #495057;
    font-size: 1.25rem;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

.settings-section h4 i {
    margin-right: 0.5rem;
    color: #007bff;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.required {
    color: #dc3545;
    margin-left: 0.25rem;
}

.modern-form-control {
    padding: 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 6px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: white;
}

.modern-form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.modern-textarea {
    min-height: 120px;
    resize: vertical;
}

.form-actions {
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.modern-btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.modern-btn i {
    margin-right: 0.5rem;
}

.modern-btn-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
}

.modern-btn-primary:hover {
    background: linear-gradient(135deg, #0056b3, #004085);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
}

.modern-btn-info {
    background: linear-gradient(135deg, #17a2b8, #138496);
    color: white;
}

.modern-btn-info:hover {
    background: linear-gradient(135deg, #138496, #117a8b);
    transform: translateY(-1px);
}

.logo-preview, .favicon-preview {
    margin: 1rem 0;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 6px;
    text-align: center;
}

.current-logo {
    max-height: 80px;
    max-width: 200px;
}

.current-favicon {
    max-height: 32px;
    max-width: 32px;
}

.file-upload-wrapper {
    position: relative;
    display: inline-block;
    width: 100%;
}

.modern-file-input {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.file-upload-info {
    padding: 1rem;
    border: 2px dashed #ced4da;
    border-radius: 6px;
    text-align: center;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.file-upload-info:hover {
    border-color: #007bff;
    background: #e3f2fd;
}

.file-upload-info i {
    font-size: 1.5rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
    display: block;
}

.modern-alert {
    padding: 1rem 1.5rem;
    border-radius: 6px;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.modern-alert-success {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.modern-alert-danger {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.modern-alert i {
    font-size: 1.25rem;
    margin-right: 1rem;
}

.alert-content {
    flex: 1;
}

.alert-content strong {
    display: block;
    margin-bottom: 0.25rem;
}
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #495057;
}

.logo-preview, .favicon-preview {
    margin-top: 0.5rem;
    padding: 1rem;
    background: white;
    border-radius: 8px;
    text-align: center;
    border: 2px dashed #dee2e6;
}

.current-logo {
    max-height: 80px;
    max-width: 200px;
}

.current-favicon {
    max-height: 40px;
    max-width: 40px;
}

.file-upload-wrapper {
    position: relative;
    display: inline-block;
    width: 100%;
}

.modern-file-input {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.file-upload-info {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    background: white;
    border: 2px dashed #007bff;
    border-radius: 8px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.file-upload-info:hover {
    background: #f8f9ff;
    border-color: #0056b3;
}

.file-upload-info i {
    font-size: 1.5rem;
    margin-right: 0.5rem;
    color: #007bff;
}

.form-actions {
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid #dee2e6;
}

.modern-form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.modern-form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.modern-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

.modern-textarea {
    min-height: 120px;
    resize: vertical;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.5rem;
    line-height: 1.4;
}

.form-text a {
    color: #007bff;
    text-decoration: none;
}

.form-text a:hover {
    text-decoration: underline;
}

.form-text strong {
    color: #495057;
    font-weight: 600;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.modern-tab-btn');
    const tabPanes = document.querySelectorAll('.modern-tab-pane');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and panes
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));
            
            // Add active class to clicked button and corresponding pane
            this.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
        });
    });
    
    // File upload preview
    const fileInputs = document.querySelectorAll('.modern-file-input');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'Choose file';
            const infoSpan = this.parentElement.querySelector('.file-upload-info span');
            if (infoSpan) {
                infoSpan.textContent = fileName;
            }
        });
    });
});
</script>

<?php require_once('footer.php'); ?>
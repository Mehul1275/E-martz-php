<?php require_once('header.php'); ?>

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

    $path = $_FILES['about_banner']['name'];
    $path_tmp = $_FILES['about_banner']['tmp_name'];

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
            $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $about_banner = $row['about_banner'];
                unlink('../assets/uploads/'.$about_banner);
            }

            // updating the data
            $final_name = 'about-banner'.'.'.$ext;
            move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_page SET about_title=?,about_content=?,about_banner=?,about_meta_title=?,about_meta_keyword=?,about_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['about_title'],$_POST['about_content'],$final_name,$_POST['about_meta_title'],$_POST['about_meta_keyword'],$_POST['about_meta_description']));
        } else {
            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_page SET about_title=?,about_content=?,about_meta_title=?,about_meta_keyword=?,about_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['about_title'],$_POST['about_content'],$_POST['about_meta_title'],$_POST['about_meta_keyword'],$_POST['about_meta_description']));
        }

        $success_message = 'About Page Information is updated successfully.';
        
    }
    
}



if(isset($_POST['form_faq'])) {
    
    $valid = 1;

    if(empty($_POST['faq_title'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }

    $path = $_FILES['faq_banner']['name'];
    $path_tmp = $_FILES['faq_banner']['tmp_name'];

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
            $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $faq_banner = $row['faq_banner'];
                unlink('../assets/uploads/'.$faq_banner);
            }

            // updating the data
            $final_name = 'faq-banner'.'.'.$ext;
            move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_page SET faq_title=?,faq_banner=?,faq_meta_title=?,faq_meta_keyword=?,faq_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['faq_title'],$final_name,$_POST['faq_meta_title'],$_POST['faq_meta_keyword'],$_POST['faq_meta_description']));
        } else {
            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_page SET faq_title=?,faq_meta_title=?,faq_meta_keyword=?,faq_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['faq_title'],$_POST['faq_meta_title'],$_POST['faq_meta_keyword'],$_POST['faq_meta_description']));
        }

        $success_message = 'FAQ Page Information is updated successfully.';
        
    }
    
}



if(isset($_POST['form_contact'])) {
    
    $valid = 1;

    if(empty($_POST['contact_title'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }

    $path = $_FILES['contact_banner']['name'];
    $path_tmp = $_FILES['contact_banner']['tmp_name'];

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
            $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $contact_banner = $row['contact_banner'];
                unlink('../assets/uploads/'.$contact_banner);
            }

            // updating the data
            $final_name = 'contact-banner'.'.'.$ext;
            move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_page SET contact_title=?,contact_banner=?,contact_meta_title=?,contact_meta_keyword=?,contact_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['contact_title'],$final_name,$_POST['contact_meta_title'],$_POST['contact_meta_keyword'],$_POST['contact_meta_description']));
        } else {
            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_page SET contact_title=?,contact_meta_title=?,contact_meta_keyword=?,contact_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['contact_title'],$_POST['contact_meta_title'],$_POST['contact_meta_keyword'],$_POST['contact_meta_description']));
        }

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
    $path = $_FILES['tnc_banner']['name'];
    $path_tmp = $_FILES['tnc_banner']['tmp_name'];
    if($path != '') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }
    if($valid == 1) {
        if($path != '') {
            $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $tnc_banner = $row['tnc_banner'];
                if($tnc_banner) unlink('../assets/uploads/'.$tnc_banner);
            }
            $final_name = 'tnc-banner.'.$ext;
            move_uploaded_file($path_tmp, '../assets/uploads/'.$final_name);
            $statement = $pdo->prepare("UPDATE tbl_page SET tnc_title=?, tnc_content=?, tnc_banner=?, tnc_meta_title=?, tnc_meta_keyword=?, tnc_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['tnc_title'], $_POST['tnc_content'], $final_name, $_POST['tnc_meta_title'], $_POST['tnc_meta_keyword'], $_POST['tnc_meta_description']));
        } else {
            $statement = $pdo->prepare("UPDATE tbl_page SET tnc_title=?, tnc_content=?, tnc_meta_title=?, tnc_meta_keyword=?, tnc_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['tnc_title'], $_POST['tnc_content'], $_POST['tnc_meta_title'], $_POST['tnc_meta_keyword'], $_POST['tnc_meta_description']));
        }
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
    $path = $_FILES['shipping_banner']['name'];
    $path_tmp = $_FILES['shipping_banner']['tmp_name'];
    if($path != '') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }
    if($valid == 1) {
        if($path != '') {
            $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $shipping_banner = $row['shipping_banner'];
                if($shipping_banner) unlink('../assets/uploads/'.$shipping_banner);
            }
            $final_name = 'shipping-banner.'.$ext;
            move_uploaded_file($path_tmp, '../assets/uploads/'.$final_name);
            $statement = $pdo->prepare("UPDATE tbl_page SET shipping_title=?, shipping_content=?, shipping_banner=?, shipping_meta_title=?, shipping_meta_keyword=?, shipping_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['shipping_title'], $_POST['shipping_content'], $final_name, $_POST['shipping_meta_title'], $_POST['shipping_meta_keyword'], $_POST['shipping_meta_description']));
        } else {
            $statement = $pdo->prepare("UPDATE tbl_page SET shipping_title=?, shipping_content=?, shipping_meta_title=?, shipping_meta_keyword=?, shipping_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['shipping_title'], $_POST['shipping_content'], $_POST['shipping_meta_title'], $_POST['shipping_meta_keyword'], $_POST['shipping_meta_description']));
        }
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
    $path = $_FILES['privacy_banner']['name'];
    $path_tmp = $_FILES['privacy_banner']['tmp_name'];
    if($path != '') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }
    if($valid == 1) {
        if($path != '') {
            $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $privacy_banner = $row['privacy_banner'];
                if($privacy_banner) unlink('../assets/uploads/'.$privacy_banner);
            }
            $final_name = 'privacy-banner.'.$ext;
            move_uploaded_file($path_tmp, '../assets/uploads/'.$final_name);
            $statement = $pdo->prepare("UPDATE tbl_page SET privacy_title=?, privacy_content=?, privacy_banner=?, privacy_meta_title=?, privacy_meta_keyword=?, privacy_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['privacy_title'], $_POST['privacy_content'], $final_name, $_POST['privacy_meta_title'], $_POST['privacy_meta_keyword'], $_POST['privacy_meta_description']));
        } else {
            $statement = $pdo->prepare("UPDATE tbl_page SET privacy_title=?, privacy_content=?, privacy_meta_title=?, privacy_meta_keyword=?, privacy_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['privacy_title'], $_POST['privacy_content'], $_POST['privacy_meta_title'], $_POST['privacy_meta_keyword'], $_POST['privacy_meta_description']));
        }
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
    $path = $_FILES['seller_tnc_banner']['name'];
    $path_tmp = $_FILES['seller_tnc_banner']['tmp_name'];
    if($path != '') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }
    if($valid == 1) {
        if($path != '') {
            $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $seller_tnc_banner = $row['seller_tnc_banner'];
                if($seller_tnc_banner) unlink('../assets/uploads/'.$seller_tnc_banner);
            }
            $final_name = 'seller-tnc-banner.'.$ext;
            move_uploaded_file($path_tmp, '../assets/uploads/'.$final_name);
            $statement = $pdo->prepare("UPDATE tbl_page SET seller_tnc_title=?, seller_tnc_content=?, seller_tnc_banner=?, seller_tnc_meta_title=?, seller_tnc_meta_keyword=?, seller_tnc_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['seller_tnc_title'], $_POST['seller_tnc_content'], $final_name, $_POST['seller_tnc_meta_title'], $_POST['seller_tnc_meta_keyword'], $_POST['seller_tnc_meta_description']));
        } else {
            $statement = $pdo->prepare("UPDATE tbl_page SET seller_tnc_title=?, seller_tnc_content=?, seller_tnc_meta_title=?, seller_tnc_meta_keyword=?, seller_tnc_meta_description=? WHERE id=1");
            $statement->execute(array($_POST['seller_tnc_title'], $_POST['seller_tnc_content'], $_POST['seller_tnc_meta_title'], $_POST['seller_tnc_meta_keyword'], $_POST['seller_tnc_meta_description']));
        }
        $success_message = 'Seller T&C Page Information is updated successfully.';
    }
}

?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Page Settings</h1>
    </div>
</section>

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


<section class="content" style="min-height:auto;margin-bottom: -30px;">
    <div class="row">
        <div class="col-md-12">
            <?php if($error_message): ?>
            <div class="callout callout-danger">
            
            <p>
            <?php echo $error_message; ?>
            </p>
            </div>
            <?php endif; ?>

            <?php if($success_message): ?>
            <div class="callout callout-success">
            
            <p><?php echo $success_message; ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">
                            
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">About Us</a></li>
                        <li><a href="#tab_2" data-toggle="tab">FAQ</a></li>
                        <li><a href="#tab_4" data-toggle="tab">Contact</a></li>
                        <li><a href="#tab_tnc" data-toggle="tab">Terms & Conditions</a></li>
                        <li><a href="#tab_shipping" data-toggle="tab">Shipping & Returns</a></li>
                        <li><a href="#tab_privacy" data-toggle="tab">Privacy Policy</a></li>
                        <li><a href="#tab_seller_tnc" data-toggle="tab">Seller T&C</a></li>
                    </ul>

                    <!-- About us Page Content -->

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Page Title * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="about_title" value="<?php echo $about_title; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Page Content * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="about_content" id="editor1"><?php echo $about_content; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Existing Banner Photo</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <img src="../assets/uploads/<?php echo $about_banner; ?>" class="existing-photo" style="height:80px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">New Banner Photo</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <input type="file" name="about_banner">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Meta Title</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" name="about_meta_title" value="<?php echo $about_meta_title; ?>">
                                        </div>
                                    </div>             
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Meta Keyword </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="about_meta_keyword" style="height:100px;"><?php echo $about_meta_keyword; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Meta Description </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="about_meta_description" style="height:100px;"><?php echo $about_meta_description; ?></textarea>
                                        </div>
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_about">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>

        <!-- FAQ Page Content -->

                        <div class="tab-pane" id="tab_2">
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Page Title * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="faq_title" value="<?php echo $faq_title; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Existing Banner Photo</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <img src="../assets/uploads/<?php echo $faq_banner; ?>" class="existing-photo" style="height:80px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">New Banner Photo</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <input type="file" name="faq_banner">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Meta Title</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" name="faq_meta_title" value="<?php echo $faq_meta_title; ?>">
                                        </div>
                                    </div>             
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Meta Keyword </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="faq_meta_keyword" style="height:100px;"><?php echo $faq_meta_keyword; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Meta Description </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="faq_meta_description" style="height:100px;"><?php echo $faq_meta_description; ?></textarea>
                                        </div>
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_faq">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>

                        <!-- End of FAQ Page Content -->

                        <div class="tab-pane" id="tab_4">
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Page Title * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="contact_title" value="<?php echo $contact_title; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Existing Banner Photo</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <img src="../assets/uploads/<?php echo $contact_banner; ?>" class="existing-photo" style="height:80px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">New Banner Photo</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <input type="file" name="contact_banner">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Meta Title</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" name="contact_meta_title" value="<?php echo $contact_meta_title; ?>">
                                        </div>
                                    </div>             
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Meta Keyword </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="contact_meta_keyword" style="height:100px;"><?php echo $contact_meta_keyword; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Meta Description </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="contact_meta_description" style="height:100px;"><?php echo $contact_meta_description; ?></textarea>
                                        </div>
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_contact">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>

        <!-- Terms & Conditions Page Content -->
        <div class="tab-pane" id="tab_tnc">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Page Title *</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="tnc_title" value="<?php echo $tnc_title; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Page Content *</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="tnc_content" id="editor_tnc"><?php echo $tnc_content; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Existing Banner Photo</label>
                        <div class="col-sm-6" style="padding-top:6px;">
                            <?php if(!empty($tnc_banner)) { ?><img src="../assets/uploads/<?php echo $tnc_banner; ?>" class="existing-photo" style="height:80px;"><?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">New Banner Photo</label>
                        <div class="col-sm-6" style="padding-top:6px;">
                            <input type="file" name="tnc_banner">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Meta Title</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="tnc_meta_title" value="<?php echo $tnc_meta_title; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Meta Keyword</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="tnc_meta_keyword" style="height:100px;"><?php echo $tnc_meta_keyword; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Meta Description</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="tnc_meta_description" style="height:100px;"><?php echo $tnc_meta_description; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success pull-left" name="form_tnc">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <!-- Shipping & Returns Page Content -->
        <div class="tab-pane" id="tab_shipping">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Page Title *</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="shipping_title" value="<?php echo $shipping_title; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Page Content *</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="shipping_content" id="editor_shipping"><?php echo $shipping_content; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Existing Banner Photo</label>
                        <div class="col-sm-6" style="padding-top:6px;">
                            <?php if(!empty($shipping_banner)) { ?><img src="../assets/uploads/<?php echo $shipping_banner; ?>" class="existing-photo" style="height:80px;"><?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">New Banner Photo</label>
                        <div class="col-sm-6" style="padding-top:6px;">
                            <input type="file" name="shipping_banner">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Meta Title</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="shipping_meta_title" value="<?php echo $shipping_meta_title; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Meta Keyword</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="shipping_meta_keyword" style="height:100px;"><?php echo $shipping_meta_keyword; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Meta Description</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="shipping_meta_description" style="height:100px;"><?php echo $shipping_meta_description; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success pull-left" name="form_shipping">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <!-- Privacy Policy Page Content -->
        <div class="tab-pane" id="tab_privacy">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Page Title *</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="privacy_title" value="<?php echo $privacy_title; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Page Content *</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="privacy_content" id="editor_privacy"><?php echo $privacy_content; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Existing Banner Photo</label>
                        <div class="col-sm-6" style="padding-top:6px;">
                            <?php if(!empty($privacy_banner)) { ?><img src="../assets/uploads/<?php echo $privacy_banner; ?>" class="existing-photo" style="height:80px;"><?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">New Banner Photo</label>
                        <div class="col-sm-6" style="padding-top:6px;">
                            <input type="file" name="privacy_banner">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Meta Title</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="privacy_meta_title" value="<?php echo $privacy_meta_title; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Meta Keyword</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="privacy_meta_keyword" style="height:100px;"><?php echo $privacy_meta_keyword; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Meta Description</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="privacy_meta_description" style="height:100px;"><?php echo $privacy_meta_description; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success pull-left" name="form_privacy">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>

        <!-- Seller T&C Page Content -->
        <div class="tab-pane" id="tab_seller_tnc">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Page Title *</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="seller_tnc_title" value="<?php echo htmlspecialchars($seller_tnc_title); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Page Content *</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="seller_tnc_content" id="editor_seller_tnc"><?php echo htmlspecialchars($seller_tnc_content); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Existing Banner Photo</label>
                        <div class="col-sm-6" style="padding-top:6px;">
                            <?php if(!empty($seller_tnc_banner)) { ?><img src="../assets/uploads/<?php echo $seller_tnc_banner; ?>" class="existing-photo" style="height:80px;"><?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">New Banner Photo</label>
                        <div class="col-sm-6" style="padding-top:6px;">
                            <input type="file" name="seller_tnc_banner">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Meta Title</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="seller_tnc_meta_title" value="<?php echo htmlspecialchars($seller_tnc_meta_title); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Meta Keyword</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="seller_tnc_meta_keyword" style="height:100px;"><?php echo htmlspecialchars($seller_tnc_meta_keyword); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Meta Description</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="seller_tnc_meta_description" style="height:100px;"><?php echo htmlspecialchars($seller_tnc_meta_description); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success pull-left" name="form_seller_tnc">Update</button>
                        </div>
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
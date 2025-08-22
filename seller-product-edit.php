<?php
session_start();
include("admin/inc/config.php");
include("admin/inc/functions.php");
if(!isset($_SESSION['seller'])) {
    header('Location: seller-login.php');
    exit;
}
$seller_id = $_SESSION['seller']['id'];
$error_message = '';
$success_message = '';

if(!isset($_REQUEST['id'])) {
    header('location: seller-products.php');
    exit;
} else {
    // Check the id is valid or not and belongs to this seller
    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=? AND seller_id=?");
    $statement->execute(array($_REQUEST['id'], $seller_id));
    $total = $statement->rowCount();
    if( $total == 0 ) {
        header('location: seller-products.php');
        exit;
    }
}

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
    }

    if(empty($_POST['p_current_price'])) {
        $valid = 0;
        $error_message .= "Current Price can not be empty<br>";
    }

    if(empty($_POST['p_qty'])) {
        $valid = 0;
        $error_message .= "Quantity can not be empty<br>";
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
    }

    if($valid == 1) {

        if( isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmp_name"]) )
        {
            $photo = array();
            $photo = $_FILES['photo']["name"];
            $photo = array_values(array_filter($photo));

            $photo_temp = array();
            $photo_temp = $_FILES['photo']["tmp_name"];
            $photo_temp = array_values(array_filter($photo_temp));

            $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product_photo'");
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row) {
                $next_id1=$row[10];
            }
            $z = $next_id1;

            $m=0;
            for($i=0;$i<count($photo);$i++)
            {
                $my_ext1 = pathinfo( $photo[$i], PATHINFO_EXTENSION );
                if( $my_ext1=='jpg' || $my_ext1=='png' || $my_ext1=='jpeg' || $my_ext1=='gif' ) {
                    $final_name1[$m] = $z.'.'.$my_ext1;
                    move_uploaded_file($photo_temp[$i],"assets/uploads/product_photos/".$final_name1[$m]);
                    $m++;
                    $z++;
                }
            }

            if(isset($final_name1)) {
                for($i=0;$i<count($final_name1);$i++)
                {
                    $statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo,p_id) VALUES (?,?)");
                    $statement->execute(array($final_name1[$i],$_REQUEST['id']));
                }
            }            
        }

        if($path == '') {
            $statement = $pdo->prepare("UPDATE tbl_product SET 
                                    p_name=?, 
                                    p_old_price=?, 
                                    p_current_price=?, 
                                    p_qty=?,
                                    p_description=?,
                                    p_short_description=?,
                                    p_feature=?,
                                    ecat_id=?
                                    WHERE p_id=? AND seller_id=?");
            $statement->execute(array(
                $_POST['p_name'],
                $_POST['p_old_price'],
                $_POST['p_current_price'],
                $_POST['p_qty'],
                $_POST['p_description'],
                $_POST['p_short_description'],
                $_POST['p_feature'],
                $_POST['ecat_id'],
                $_REQUEST['id'],
                $seller_id
            ));
        } else {
            // Getting photo ID to unlink from folder
            $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=? AND seller_id=?");
            $statement->execute(array($_REQUEST['id'], $seller_id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
            foreach ($result as $row) {
                $p_featured_photo = $row['p_featured_photo'];
                if(file_exists('assets/uploads/'.$p_featured_photo)) {
                    unlink('assets/uploads/'.$p_featured_photo);
                }
            }

            $final_name = 'product-featured-'.$_REQUEST['id'].'.'.$ext;
            move_uploaded_file( $path_tmp, 'assets/uploads/'.$final_name );

            $statement = $pdo->prepare("UPDATE tbl_product SET 
                                    p_name=?, 
                                    p_old_price=?, 
                                    p_current_price=?, 
                                    p_qty=?,
                                    p_description=?,
                                    p_short_description=?,
                                    p_feature=?,
                                    p_featured_photo=?,
                                    ecat_id=?
                                    WHERE p_id=? AND seller_id=?");
            $statement->execute(array(
                $_POST['p_name'],
                $_POST['p_old_price'],
                $_POST['p_current_price'],
                $_POST['p_qty'],
                $_POST['p_description'],
                $_POST['p_short_description'],
                $_POST['p_feature'],
                $final_name,
                $_POST['ecat_id'],
                $_REQUEST['id'],
                $seller_id
            ));
        }

        // Update size and color associations
        // First delete existing associations
        $statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
        $statement->execute(array($_REQUEST['id']));
        
        $statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
        $statement->execute(array($_REQUEST['id']));

        // Insert new size associations
        if(isset($_POST['size'])) {
            foreach($_POST['size'] as $size_id) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_size (p_id,size_id) VALUES (?,?)");
                $statement->execute(array($_REQUEST['id'],$size_id));
            }
        }

        // Insert new color associations
        if(isset($_POST['color'])) {
            foreach($_POST['color'] as $color_id) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_color (p_id,color_id) VALUES (?,?)");
                $statement->execute(array($_REQUEST['id'],$color_id));
            }
        }

        $success_message = 'Product is updated successfully!';
    }
}

$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=? AND seller_id=?");
$statement->execute(array($_REQUEST['id'], $seller_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            

// Initialize all variables with default values
$p_name = '';
$p_old_price = '';
$p_current_price = '';
$p_qty = '';
$p_description = '';
$p_short_description = '';
$p_feature = '';
$p_condition = '';
$p_return_policy = '';
$p_featured_photo = '';
$tcat_id = '';
$mcat_id = '';
$ecat_id = '';

if (!empty($result)) {
    foreach ($result as $row) {
        $p_name = isset($row['p_name']) ? $row['p_name'] : '';
        $p_old_price = isset($row['p_old_price']) ? $row['p_old_price'] : '';
        $p_current_price = isset($row['p_current_price']) ? $row['p_current_price'] : '';
        $p_qty = isset($row['p_qty']) ? $row['p_qty'] : '';
        $p_description = isset($row['p_description']) ? $row['p_description'] : '';
        $p_short_description = isset($row['p_short_description']) ? $row['p_short_description'] : '';
        $p_feature = isset($row['p_feature']) ? $row['p_feature'] : '';
        $p_condition = isset($row['p_condition']) ? $row['p_condition'] : '';
        $p_return_policy = isset($row['p_return_policy']) ? $row['p_return_policy'] : '';
        $p_featured_photo = isset($row['p_featured_photo']) ? $row['p_featured_photo'] : '';
        $tcat_id = isset($row['tcat_id']) ? $row['tcat_id'] : '';
        $mcat_id = isset($row['mcat_id']) ? $row['mcat_id'] : '';
        $ecat_id = isset($row['ecat_id']) ? $row['ecat_id'] : '';
    }
}

// Get current size and color selections
$statement = $pdo->prepare("SELECT size_id FROM tbl_product_size WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$current_sizes = $statement->fetchAll(PDO::FETCH_COLUMN);

$statement = $pdo->prepare("SELECT color_id FROM tbl_product_color WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$current_colors = $statement->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Seller Panel - Edit Product</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin/css/ionicons.min.css">
    <link rel="stylesheet" href="admin/css/AdminLTE.min.css">
    <link rel="stylesheet" href="admin/css/_all-skins.min.css">
    <link rel="stylesheet" href="admin/css/select2.min.css">
    <link rel="stylesheet" href="admin/css/style.css">
    <link rel="stylesheet" href="admin/css/summernote.css">
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<?php include('seller-header.php'); ?>
<div class="wrapper">
<?php include('seller-sidebar.php'); ?>
    <div class="content-wrapper" style="min-height:100vh;">
        <section class="content-header">
            <div class="content-header-left">
                <h1>Edit Product</h1>
            </div>
            <div class="content-header-right">
                <a href="seller-products.php" class="btn btn-primary btn-sm">View All</a>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <?php if($error_message): ?>
                        <div class="callout callout-danger">
                            <p><?php echo $error_message; ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if($success_message): ?>
                        <div class="callout callout-success">
                            <p><?php echo $success_message; ?></p>
                        </div>
                    <?php endif; ?>
                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Top Level Category Name <span>*</span></label>
                                    <div class="col-sm-4">
                                        <select name="tcat_id" class="form-control select2 top-cat">
                                            <option value="">Select Top Level Category</option>
                                            <?php
                                            $statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");
                                            $statement->execute();
                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                                            foreach ($result as $row) {
                                                ?>
                                                <option value="<?php echo $row['tcat_id']; ?>" <?php if($row['tcat_id'] == $tcat_id){echo 'selected';} ?>><?php echo $row['tcat_name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Mid Level Category Name <span>*</span></label>
                                    <div class="col-sm-4">
                                        <select name="mcat_id" class="form-control select2 mid-cat">
                                            <option value="">Select Mid Level Category</option>
                                            <?php
                                            if($tcat_id) {
                                                $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=? ORDER BY mcat_name ASC");
                                                $statement->execute(array($tcat_id));
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                                                foreach ($result as $row) {
                                                    ?>
                                                    <option value="<?php echo $row['mcat_id']; ?>" <?php if($row['mcat_id'] == $mcat_id){echo 'selected';} ?>><?php echo $row['mcat_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">End Level Category Name <span>*</span></label>
                                    <div class="col-sm-4">
                                        <select name="ecat_id" class="form-control select2 end-cat">
                                            <option value="">Select End Level Category</option>
                                            <?php
                                            if($mcat_id) {
                                                $statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=? ORDER BY ecat_name ASC");
                                                $statement->execute(array($mcat_id));
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                                                foreach ($result as $row) {
                                                    ?>
                                                    <option value="<?php echo $row['ecat_id']; ?>" <?php if($row['ecat_id'] == $ecat_id){echo 'selected';} ?>><?php echo $row['ecat_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Product Name <span>*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" name="p_name" class="form-control" value="<?php echo $p_name; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Old Price <br><span style="font-size:10px;font-weight:normal;">(In INR)</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" name="p_old_price" class="form-control" value="<?php echo $p_old_price; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Current Price * <br><span style="font-size:10px;font-weight:normal;">(In INR)</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" name="p_current_price" class="form-control" value="<?php echo $p_current_price; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Quantity <span>*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" name="p_qty" class="form-control" value="<?php echo $p_qty; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Select Size</label>
                                    <div class="col-sm-4">
                                        <select name="size[]" class="form-control select2" multiple="multiple">
                                            <?php
                                            $statement = $pdo->prepare("SELECT * FROM tbl_size ORDER BY size_id ASC");
                                            $statement->execute();
                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result as $row) {
                                                ?>
                                                <option value="<?php echo $row['size_id']; ?>" <?php if(in_array($row['size_id'], $current_sizes)){echo 'selected';} ?>><?php echo $row['size_name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Select Color</label>
                                    <div class="col-sm-4">
                                        <select name="color[]" class="form-control select2" multiple="multiple">
                                            <?php
                                            $statement = $pdo->prepare("SELECT * FROM tbl_color ORDER BY color_id ASC");
                                            $statement->execute();
                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result as $row) {
                                                ?>
                                                <option value="<?php echo $row['color_id']; ?>" <?php if(in_array($row['color_id'], $current_colors)){echo 'selected';} ?>><?php echo $row['color_name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Featured Photo</label>
                                    <div class="col-sm-4" style="padding-top:4px;">
                                        <input type="file" name="p_featured_photo">
                                        <p style="color:red;">(Only jpg, jpeg, gif and png are allowed)</p>
                                        <img src="assets/uploads/<?php echo $p_featured_photo; ?>" alt="" style="width:200px;margin-top:10px;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Other Photos</label>
                                    <div class="col-sm-4" style="padding-top:4px;">
                                        <table id="ProductTable" style="width:100%;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="upload-btn">
                                                            <input type="file" name="photo[]" style="margin-bottom:5px;">
                                                        </div>
                                                    </td>
                                                    <td style="width:28px;"><a href="javascript:void()" class="Delete btn btn-danger btn-xs">X</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="button" id="btnAddNew" value="Add Item" style="margin-top: 5px;margin-bottom:10px;border:0;color: #fff;font-size: 14px;border-radius:3px;" class="btn btn-warning btn-xs">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Current Photos</label>
                                    <div class="col-sm-4">
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
                                        $statement->execute(array($_REQUEST['id']));
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                                        foreach ($result as $row) {
                                            ?>
                                            <img src="assets/uploads/product_photos/<?php echo $row['photo']; ?>" alt="" style="width:150px;margin:5px;">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Description</label>
                                    <div class="col-sm-8">
                                        <textarea name="p_description" class="form-control" cols="30" rows="10" id="editor1"><?php echo $p_description; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Short Description</label>
                                    <div class="col-sm-8">
                                        <textarea name="p_short_description" class="form-control" cols="30" rows="10" id="editor2"><?php echo $p_short_description; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Features</label>
                                    <div class="col-sm-8">
                                        <textarea name="p_feature" class="form-control" cols="30" rows="10" id="editor3"><?php echo $p_feature; ?></textarea>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-success pull-left" name="form1">Update Product</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
    // Dynamic category dropdowns (AJAX)
    $('.top-cat').on('change', function() {
        var tcat_id = $(this).val();
        $.ajax({
            url: 'admin/get-mid-category.php',
            type: 'POST',
            data: { id: tcat_id },
            success: function(data) {
                $('.mid-cat').html(data).trigger('change');
                $('.end-cat').html('<option value="">Select End Level Category</option>').trigger('change');
            }
        });
    });
    $('.mid-cat').on('change', function() {
        var mcat_id = $(this).val();
        $.ajax({
            url: 'admin/get-end-category.php',
            type: 'POST',
            data: { id: mcat_id },
            success: function(data) {
                $('.end-cat').html(data).trigger('change');
            }
        });
    });
    // Add/Remove multiple photo upload fields
    $('#btnAddNew').on('click', function() {
        var html = '<tr><td><div class="upload-btn"><input type="file" name="photo[]" style="margin-bottom:5px;"></div></td><td style="width:28px;"><a href="javascript:void()" class="Delete btn btn-danger btn-xs">X</a></td></tr>';
        $('#ProductTable tbody').append(html);
    });
    $(document).on('click', '.Delete', function() {
        $(this).closest('tr').remove();
    });
    $('.select2').select2();
    // Initialize Summernote for all editor fields
    $('#editor1, #editor2, #editor3').summernote({
        height: 200
    });
});
</script>
</body>
</html> 
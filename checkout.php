<?php 
declare(strict_types=1);
require_once('header.php'); 
?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_checkout = $row['banner_checkout'];
}
?>

<?php
if(!isset($_SESSION['cart_p_id']) || empty($_SESSION['cart_p_id'])) {
    header('location: cart.php');
    exit();
}
?>

<?php
if(!isset($_SESSION['customer']['cust_id'])) {
    echo '<div style="margin:60px auto;text-align:center;max-width:500px;padding:40px 20px;background:#fff;border-radius:8px;box-shadow:0 2px 12px rgba(0,0,0,0.08);font-size:22px;color:#b20b39;font-weight:600;">Please login to purchase.<br><br><a href="login.php" class="btn btn-danger" style="margin-top:18px;">Login</a></div>';
    require_once('footer.php');
    exit();
}
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo htmlspecialchars($banner_checkout, ENT_QUOTES, 'UTF-8'); ?>)">
    <div class="overlay"></div>
    <div class="page-banner-inner">
        <h1><?php echo LANG_VALUE_22; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <?php if(!isset($_SESSION['customer'])): ?>
                    <p>
                        <a href="login.php" class="btn btn-md btn-danger"><?php echo LANG_VALUE_160; ?></a>
                    </p>
                <?php else: ?>

                <h3 class="special"><?php echo LANG_VALUE_26; ?></h3>
                <div class="cart">
                    <table class="table table-responsive table-hover table-bordered">
                        <tr>
                            <th><?php echo '#' ?></th>
                            <th><?php echo LANG_VALUE_8; ?></th>
                            <th><?php echo LANG_VALUE_47; ?></th>
                            <th><?php echo LANG_VALUE_157; ?></th>
                            <th><?php echo LANG_VALUE_158; ?></th>
                            <th><?php echo LANG_VALUE_159; ?></th>
                            <th><?php echo LANG_VALUE_55; ?></th>
                            <th class="text-right"><?php echo LANG_VALUE_82; ?></th>
                        </tr>
                         <?php
                        $table_total_price = 0;

                        $i = 0;
                        foreach($_SESSION['cart_p_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_id[$i] = $value;
                        }

                        $i = 0;
                        foreach($_SESSION['cart_size_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_id[$i] = $value;
                        }

                        $i = 0;
                        foreach($_SESSION['cart_size_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_name[$i] = $value;
                        }

                        $i = 0;
                        foreach($_SESSION['cart_color_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_id[$i] = $value;
                        }

                        $i = 0;
                        foreach($_SESSION['cart_color_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_name[$i] = $value;
                        }

                        $i = 0;
                        foreach($_SESSION['cart_p_qty'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_qty[$i] = $value;
                        }

                        $i = 0;
                        foreach($_SESSION['cart_p_current_price'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_current_price[$i] = $value;
                        }

                        $i = 0;
                        foreach($_SESSION['cart_p_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_name[$i] = $value;
                        }

                        $i = 0;
                        foreach($_SESSION['cart_p_featured_photo'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_featured_photo[$i] = $value;
                        }
                        ?>
                        <?php for($i=1;$i<=count($arr_cart_p_id);$i++): ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <img src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>" alt="">
                            </td>
                            <td><?php echo $arr_cart_p_name[$i]; ?></td>
                            <td><?php echo $arr_cart_size_name[$i]; ?></td>
                            <td><?php echo $arr_cart_color_name[$i]; ?></td>
                            <td>₹<?php echo number_format(floatval($arr_cart_p_current_price[$i]), 2); ?></td>
                            <td><?php echo intval($arr_cart_p_qty[$i]); ?></td>
                            <td class="text-right">
                                <?php
                                // Ensure values are numeric
                                $current_price = floatval($arr_cart_p_current_price[$i]);
                                $quantity = intval($arr_cart_p_qty[$i]);
                                $row_total_price = $current_price * $quantity;
                                $table_total_price = $table_total_price + $row_total_price;
                                ?>
                                ₹<?php echo number_format($row_total_price, 2); ?>
                            </td>
                        </tr>
                        <?php endfor; ?>           
                        <tr>
                            <th colspan="7" class="total-text"><?php echo LANG_VALUE_81; ?></th>
                            <th class="total-amount">₹<?php echo number_format($table_total_price, 2); ?></th>
                        </tr>
                        <?php
                        // Initialize shipping cost
                        $shipping_cost = 0;
                        
                        $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE country_id=?");
                        $statement->execute(array($_SESSION['customer']['cust_country']));
                        $total = $statement->rowCount();
                        if($total) {
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $shipping_cost = floatval($row['amount']);
                            }
                        } else {
                            $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost_all WHERE sca_id=1");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $shipping_cost = floatval($row['amount']);
                            }
                        }                        
                        ?>
                        <tr>
                            <td colspan="7" class="total-text"><?php echo LANG_VALUE_84; ?></td>
                            <td class="total-amount">₹<?php echo number_format($shipping_cost, 2); ?></td>
                        </tr>
                        <tr>
                            <th colspan="7" class="total-text"><?php echo LANG_VALUE_82; ?></th>
                            <th class="total-amount">
                                <?php
                                $final_total = $table_total_price + $shipping_cost;
                                ?>
                                ₹<?php echo number_format($final_total, 2); ?>
                            </th>
                        </tr>
                    </table> 
                </div>

                

                <div class="billing-address">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="special"><?php echo LANG_VALUE_161; ?></h3>
                            <table class="table table-responsive table-bordered table-hover table-striped bill-address">
                                <tr>
                                    <td><?php echo LANG_VALUE_102; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_name']; ?></p></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_103; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_cname']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_104; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_phone']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_106; ?></td>
                                    <td>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                                        $statement->execute(array($_SESSION['customer']['cust_b_country']));
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            echo $row['country_name'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_105; ?></td>
                                    <td>
                                        <?php echo nl2br($_SESSION['customer']['cust_b_address']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_107; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_city']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_108; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_state']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_109; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_zip']; ?></td>
                                </tr>                                
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h3 class="special"><?php echo LANG_VALUE_162; ?></h3>
                            <table class="table table-responsive table-bordered table-hover table-striped bill-address">
                                <tr>
                                    <td><?php echo LANG_VALUE_102; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_name']; ?></p></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_103; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_cname']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_104; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_phone']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_106; ?></td>
                                    <td>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                                        $statement->execute(array($_SESSION['customer']['cust_s_country']));
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            echo $row['country_name'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_105; ?></td>
                                    <td>
                                        <?php echo nl2br($_SESSION['customer']['cust_s_address']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_107; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_city']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_108; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_state']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_109; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_zip']; ?></td>
                                </tr> 
                            </table>
                        </div>
                    </div>                    
                </div>

                

                <div class="cart-buttons">
                    <ul>
                        <li><a href="cart.php" class="btn btn-primary"><?php echo LANG_VALUE_21; ?></a></li>
                    </ul>
                </div>

                <div class="clear"></div>
                <h3 class="special"><?php echo LANG_VALUE_33; ?></h3>
                <div class="row">
                    
                        <?php
                        $checkout_access = 1;
                        if(
                            ($_SESSION['customer']['cust_b_name']=='') ||
                            ($_SESSION['customer']['cust_b_cname']=='') ||
                            ($_SESSION['customer']['cust_b_phone']=='') ||
                            ($_SESSION['customer']['cust_b_country']=='') ||
                            ($_SESSION['customer']['cust_b_address']=='') ||
                            ($_SESSION['customer']['cust_b_city']=='') ||
                            ($_SESSION['customer']['cust_b_state']=='') ||
                            ($_SESSION['customer']['cust_b_zip']=='') ||
                            ($_SESSION['customer']['cust_s_name']=='') ||
                            ($_SESSION['customer']['cust_s_cname']=='') ||
                            ($_SESSION['customer']['cust_s_phone']=='') ||
                            ($_SESSION['customer']['cust_s_country']=='') ||
                            ($_SESSION['customer']['cust_s_address']=='') ||
                            ($_SESSION['customer']['cust_s_city']=='') ||
                            ($_SESSION['customer']['cust_s_state']=='') ||
                            ($_SESSION['customer']['cust_s_zip']=='')
                        ) {
                            $checkout_access = 0;
                        }
                        ?>
                        <?php if($checkout_access == 0): ?>
                            <div class="col-md-12">
                                <div style="color:red;font-size:22px;margin-bottom:50px;">
                                    You must have to fill up all the billing and shipping information from your dashboard panel in order to checkout the order. Please fill up the information going to <a href="customer-billing-shipping-update.php" style="color:red;text-decoration:underline;">this link</a>.
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="col-md-4">
                                
                                <div class="row">

                                                                        <div class="col-md-12 form-group">
                                        <label for=""><?php echo LANG_VALUE_34; ?> *</label>
                                        <select name="payment_method" class="form-control select2" id="advFieldsStatus">
                                            <option value=""><?php echo LANG_VALUE_35; ?></option>
                                            <option value="Razorpay">Razorpay (UPI, Cards, Net Banking)</option>
                                            <option value="Cash on Delivery">Cash on Delivery</option>
                                        </select>
                                    </div>

                                    <style>
                                        .payment-form {
                                            display: none;
                                        }
                                    </style>
                                    
                                    <form class="payment-form razorpay" action="payment/razorpay/process.php" method="post" id="razorpay_form">
                                        <input type="hidden" name="final_total" value="<?php echo $final_total; ?>">
                                        <div class="col-md-12 form-group">
                                            <input type="submit" class="btn btn-success" value="Pay with Razorpay" name="form2">
                                        </div>
                                    </form>

                                    <form class="payment-form cod" action="payment/cod/process.php" method="post" id="cod_form">
                                        <input type="hidden" name="final_total" value="<?php echo $final_total; ?>">
                                        <div class="col-md-12 form-group">
                                            <h5>Delivery Address:</h5>
                                            <div class="delivery-address" style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                                                <p><strong>Name:</strong> <?php echo $_SESSION['customer']['cust_s_name']; ?></p>
                                                <p><strong>Phone:</strong> <?php echo $_SESSION['customer']['cust_s_phone']; ?></p>
                                                <p><strong>Address:</strong> <?php echo $_SESSION['customer']['cust_s_address']; ?></p>
                                                <p><strong>City:</strong> <?php echo $_SESSION['customer']['cust_s_city']; ?></p>
                                                <p><strong>State:</strong> <?php echo $_SESSION['customer']['cust_s_state']; ?></p>
                                                <p><strong>ZIP:</strong> <?php echo $_SESSION['customer']['cust_s_zip']; ?></p>
                                                <p><strong>Country:</strong> <?php echo $_SESSION['customer']['cust_s_country']; ?></p>
                                            </div>
                                            <div class="alert alert-info">
                                                <strong>Cash on Delivery:</strong> You will pay ₹<?php echo number_format($final_total, 2); ?> when the order is delivered.
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <input type="submit" class="btn btn-warning btn-lg" value="Confirm Cash on Delivery Order" name="form3">
                                            </div>
                                        </div>
                                    </form>




                                    
                                </div>
                                    
                                
                            </div>
                        <?php endif; ?>
                        
                </div>
                

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    // Function to show only the selected payment form
    function updatePaymentVisibility() {
        var selectedMethod = $('#advFieldsStatus').val();
        console.log("Selected payment method:", selectedMethod);
        $('.payment-form').hide();
        if(selectedMethod === 'Razorpay') {
            $('.razorpay').show();
        } else if(selectedMethod === 'Cash on Delivery') {
            $('.cod').show();
        }
    }
    // Initial call on page load
    updatePaymentVisibility();
    // Update on change
    $('#advFieldsStatus').on('change', updatePaymentVisibility);
    
    // Show error message if any
    <?php if(isset($_SESSION['error_message'])): ?>
        alert('<?php echo $_SESSION['error_message']; ?>');
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    
    // Show success message if any
    <?php if(isset($_SESSION['success_message'])): ?>
        alert('<?php echo $_SESSION['success_message']; ?>');
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
});
</script>

<?php require_once('footer.php'); ?>
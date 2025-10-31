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

<!-- Enhanced Checkout Page Styles -->
<style>
/* Page Header Styling - Match Cart page */
.page-header {
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.10);
    margin-bottom: 30px;
    text-align: center;
    border-bottom: 4px solid #1e40af;
}

.page-header h1 {
    color: #0f172a;
    margin-bottom: 12px;
    font-weight: 600;
    font-size: 32px;
}

.page-header .text-muted {
    color: #475569;
    font-size: 18px;
    margin: 0;
}

/* Enhanced Checkout Steps */
.checkout-steps {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin: 30px 0;
    list-style: none;
    padding: 0;
    flex-wrap: wrap;
}

.checkout-steps li {
    background: #f1f3f4;
    color: #6c757d;
    padding: 15px 25px;
    border-radius: 8px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    min-width: 140px;
    justify-content: center;
}

.checkout-steps li.active {
    background: var(--color-primary);
    color: white;
    border-color: var(--color-primary);
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(30,64,175,0.3);
}

.checkout-steps li i {
    font-size: 16px;
}

/* Enhanced Security Indicators */
.security-indicators {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    padding: 16px;
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
    border: 1px solid #a7f3d0;
    border-radius: 8px;
    margin: 25px 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.security-indicators .icon {
    color: var(--color-success);
    font-size: 20px;
    animation: pulse 2s infinite;
}

.security-indicators .text {
    color: #065f46;
    font-weight: 600;
    font-size: 15px;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* Enhanced Checkout Sections */
.checkout-section {
    background: white;
    border: 1px solid var(--color-neutral-200);
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.checkout-section h3 {
    color: var(--color-neutral-900);
    border-bottom: 3px solid var(--color-primary);
    padding-bottom: 12px;
    margin-bottom: 25px;
    font-size: 20px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.checkout-section h3 i {
    color: var(--color-primary);
    font-size: 18px;
}

/* Enhanced Cart Table */
.cart table {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.cart table th {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    color: var(--color-neutral-900);
    font-weight: 700;
    padding: 18px 15px;
    border: none;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.cart table td {
    padding: 20px 15px;
    border-bottom: 1px solid #f1f3f4;
    vertical-align: middle;
}

.cart table tbody tr:hover {
    background: #f8f9fa;
}

.cart table img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.total-text {
    font-weight: 700;
    color: var(--color-neutral-900);
    text-align: right;
}

.total-amount {
    font-weight: 700;
    color: var(--color-primary);
    font-size: 1.1rem;
    text-align: right;
}

/* Enhanced Billing Address Tables */
.bill-address {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    margin-bottom: 20px;
}

.bill-address th,
.bill-address td {
    padding: 15px;
    border-bottom: 1px solid #f1f3f4;
}

.bill-address th {
    background: var(--color-neutral-100);
    font-weight: 600;
    color: var(--color-neutral-900);
    width: 35%;
}

.bill-address tbody tr:hover {
    background: #f8f9fa;
}

/* Enhanced Payment Methods */
.payment-methods .form-group label {
    font-size: 18px;
    font-weight: 600;
    color: var(--color-neutral-900);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.payment-methods select {
    font-size: 16px;
    padding: 15px;
    border: 2px solid var(--color-neutral-200);
    border-radius: 8px;
    background: white;
    transition: all 0.3s ease;
}

.payment-methods select:focus {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(30,64,175,0.1);
}

/* Enhanced Payment Method Cards */
.payment-method {
    border: 2px solid var(--color-neutral-200);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    transition: all 0.3s ease;
    background: white;
}

.payment-method:hover {
    border-color: var(--color-primary);
    background: #f8fafc;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.payment-method.selected {
    border-color: var(--color-primary);
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    box-shadow: 0 4px 20px rgba(30,64,175,0.15);
}

.method-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 12px;
}

.method-icon {
    font-size: 24px;
    color: var(--color-primary);
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.method-title {
    font-weight: 700;
    color: var(--color-neutral-900);
    font-size: 18px;
}

.method-description {
    color: var(--color-neutral-600);
    font-size: 14px;
    margin-bottom: 16px;
    line-height: 1.5;
}

/* Enhanced Buttons */
.cart-buttons {
    text-align: center;
    margin: 30px 0;
}

.cart-buttons .btn {
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.cart-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    text-decoration: none;
}

/* Enhanced Order Summary */
.checkout-section[style*="background:#f8fafc"] {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    border: 2px solid var(--color-primary);
    position: sticky;
    top: 20px;
}

/* Enhanced Delivery Address */
.delivery-address {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    border: 2px solid var(--color-neutral-200);
}

.delivery-address p {
    margin-bottom: 8px;
    color: var(--color-neutral-700);
}

.delivery-address strong {
    color: var(--color-neutral-900);
    font-weight: 600;
}

/* Enhanced Alert */
.alert-warning {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    border: 2px solid #fde68a;
    border-radius: 8px;
    padding: 16px;
    color: #92400e;
    display: flex;
    align-items: center;
    gap: 12px;
}

.alert-warning i {
    font-size: 20px;
    color: #d97706;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        padding: 25px 20px;
    }
    
    .page-header h1 {
        font-size: 24px;
    }
    
    .checkout-steps {
        gap: 10px;
    }
    
    .checkout-steps li {
        padding: 12px 16px;
        min-width: 120px;
        font-size: 14px;
    }
    
    .checkout-section {
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .checkout-section h3 {
        font-size: 18px;
    }
    
    .cart table th,
    .cart table td {
        padding: 12px 8px;
        font-size: 14px;
    }
    
    .cart table img {
        width: 60px;
        height: 60px;
    }
}
</style>

<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container checkout-container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1><?php echo LANG_VALUE_22; ?></h1>
                    <p class="text-muted">Complete your purchase securely and safely</p>
                </div>
                <ul class="checkout-steps">
                    <li class="active"><i class="fa fa-shopping-cart"></i> Cart</li>
                    <li class="active"><i class="fa fa-user"></i> Details</li>
                    <li><i class="fa fa-credit-card"></i> Payment</li>
                    <li><i class="fa fa-check"></i> Confirmation</li>
                </ul>
                
                <div class="security-indicators">
                    <div class="icon"><i class="fa fa-lock"></i></div>
                    <div class="text">Your information is protected with 256-bit SSL encryption</div>
                </div>

                <?php if(!isset($_SESSION['customer'])): ?>
                    <p>
                        <a href="login.php" class="btn btn-md btn-danger"><?php echo LANG_VALUE_160; ?></a>
                    </p>
                <?php else: ?>

                <div class="checkout-section">
                    <h3><i class="fa fa-shopping-cart"></i> <?php echo LANG_VALUE_26; ?></h3>
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
                </div>

                <div class="cart-buttons" style="text-align:center;margin:20px 0;">
                    <a href="cart.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> <?php echo LANG_VALUE_21; ?></a>
                </div>

                <div class="checkout-section">
                    <h3><i class="fa fa-map-marker"></i> Billing & Shipping Information</h3>
                    <div class="billing-address">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 style="color:var(--color-neutral-700);margin-bottom:16px;"><?php echo LANG_VALUE_161; ?></h4>
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
                            <h4 style="color:var(--color-neutral-700);margin-bottom:16px;"><?php echo LANG_VALUE_162; ?></h4>
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
                </div>

                <div class="checkout-section">
                    <h3><i class="fa fa-credit-card"></i> <?php echo LANG_VALUE_33; ?></h3>
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
                                <div class="alert alert-warning" style="font-size:16px;margin-bottom:30px;">
                                    <i class="fa fa-exclamation-triangle"></i> <strong>Complete Your Profile</strong><br>
                                    Please fill up all billing and shipping information to proceed with checkout. 
                                    <a href="customer-billing-shipping-update.php" class="btn btn-primary" style="margin-top:12px;">Update Information</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="col-md-8">
                                <div class="payment-methods">
                                    <div class="form-group">
                                        <label for="advFieldsStatus" style="font-size:18px;font-weight:600;color:var(--color-neutral-900);margin-bottom:16px;">
                                            <i class="fa fa-credit-card"></i> <?php echo LANG_VALUE_34; ?> *
                                        </label>
                                        <select name="payment_method" class="form-control select2" id="advFieldsStatus" style="font-size:16px;padding:12px;">
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
                                    
                                    <form class="payment-form razorpay" action="payment/razorpay/process.php" method="post" id="razorpay_form" style="margin-top:20px;">
                                        <input type="hidden" name="final_total" value="<?php echo $final_total; ?>">
                                        <div class="payment-method selected">
                                            <div class="method-header">
                                                <div class="method-icon"><i class="fa fa-credit-card"></i></div>
                                                <div class="method-title">Razorpay Payment</div>
                                            </div>
                                            <div class="method-description">Pay securely using UPI, Credit/Debit Cards, Net Banking, or Wallets</div>
                                            <div style="margin-top:16px;">
                                                <input type="submit" class="btn btn-success btn-lg" value="Pay ₹<?php echo number_format($final_total, 2); ?> Securely" name="form2">
                                            </div>
                                        </div>
                                    </form>

                                    <form class="payment-form cod" action="payment/cod/process.php" method="post" id="cod_form" style="margin-top:20px;">
                                        <input type="hidden" name="final_total" value="<?php echo $final_total; ?>">
                                        <div class="payment-method">
                                            <div class="method-header">
                                                <div class="method-icon"><i class="fa fa-money"></i></div>
                                                <div class="method-title">Cash on Delivery</div>
                                            </div>
                                            <div class="method-description">Pay when your order is delivered to your doorstep</div>
                                            
                                            <div style="margin-top:16px;">
                                                <h5 style="color:var(--color-neutral-700);margin-bottom:12px;"><i class="fa fa-map-marker"></i> Delivery Address:</h5>
                                                <div class="delivery-address" style="background: #f8fafc; padding: 16px; border-radius: var(--radius-sm); margin-bottom: 16px; border: 1px solid var(--color-neutral-200);">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><strong>Name:</strong> <?php echo $_SESSION['customer']['cust_s_name']; ?></p>
                                                            <p><strong>Phone:</strong> <?php echo $_SESSION['customer']['cust_s_phone']; ?></p>
                                                            <p><strong>Address:</strong> <?php echo $_SESSION['customer']['cust_s_address']; ?></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>City:</strong> <?php echo $_SESSION['customer']['cust_s_city']; ?></p>
                                                            <p><strong>State:</strong> <?php echo $_SESSION['customer']['cust_s_state']; ?></p>
                                                            <p><strong>ZIP:</strong> <?php echo $_SESSION['customer']['cust_s_zip']; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="alert alert-warning">
                                                    <i class="fa fa-info-circle"></i> <strong>Cash on Delivery:</strong> You will pay ₹<?php echo number_format($final_total, 2); ?> when the order is delivered to your address.
                                                </div>
                                                <input type="submit" class="btn btn-warning btn-lg" value="Confirm Cash on Delivery Order" name="form3">
                                            </div>
                                        </div>
                                    </form>




                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="checkout-section" style="background:#f8fafc;">
                                    <h4 style="color:var(--color-neutral-900);margin-bottom:16px;"><i class="fa fa-info-circle"></i> Order Summary</h4>
                                    <div style="margin-bottom:16px;">
                                        <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                                            <span>Subtotal:</span>
                                            <span>₹<?php echo number_format($table_total_price, 2); ?></span>
                                        </div>
                                        <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                                            <span>Shipping:</span>
                                            <span>₹<?php echo number_format($shipping_cost, 2); ?></span>
                                        </div>
                                        <hr>
                                        <div style="display:flex;justify-content:space-between;font-weight:700;font-size:18px;color:var(--color-primary);">
                                            <span>Total:</span>
                                            <span>₹<?php echo number_format($final_total, 2); ?></span>
                                        </div>
                                    </div>
                                    <div class="security-indicators">
                                        <div class="icon"><i class="fa fa-shield"></i></div>
                                        <div class="text">Secure Payment Guaranteed</div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                </div>
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
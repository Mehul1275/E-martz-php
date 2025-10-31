<?php 
declare(strict_types=1);
require_once('header.php'); 
?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_cart = $row['banner_cart'];
}
?>

<?php
$error_message = '';
if(isset($_POST['form1'])) {

    $i = 0;
    $statement = $pdo->prepare("SELECT * FROM tbl_product");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $i++;
        $table_product_id[$i] = $row['p_id'];
        $table_quantity[$i] = $row['p_qty'];
    }

    $i = 0;
    foreach($_POST['product_id'] as $val) {
        $i++;
        $arr1[$i] = (int)$val;
    }
    $i = 0;
    foreach($_POST['quantity'] as $val) {
        $i++;
        $arr2[$i] = (int)$val;
    }
    $i = 0;
    foreach($_POST['product_name'] as $val) {
        $i++;
        $arr3[$i] = sanitize_input($val);
    }

    $allow_update = 1;
    for($i = 1; $i <= count($arr1); $i++) {
        for($j = 1; $j <= count($table_product_id); $j++) {
            if($arr1[$i] == $table_product_id[$j]) {
                $temp_index = $j;
                break;
            }
        }
        if($table_quantity[$temp_index] < $arr2[$i]) {
        	$allow_update = 0;
            $error_message .= '"'.$arr2[$i].'" items are not available for "'.$arr3[$i].'"\n';
        } else {
            $_SESSION['cart_p_qty'][$i] = $arr2[$i];
        }
    }
    $error_message .= '\nOther items quantity are updated successfully!';
    ?>
    
    <?php if($allow_update == 0): ?>
    	<script>alert('<?php echo $error_message; ?>');</script>
	<?php else: ?>
		<script>alert('All Items Quantity Update is Successful!');</script>
	<?php endif; ?>
    <?php

}
?>

<!-- Modern Cart Page Styles -->
<style>
/* Page Header Styling - Match Contact Us page */
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

.cart-empty {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin: 40px auto;
    max-width: 600px;
}

.cart-empty i {
    font-size: 4rem;
    color: #e9ecef;
    margin-bottom: 20px;
}

.cart-empty h2 {
    color: #495057;
    margin-bottom: 15px;
    font-weight: 600;
}

.cart-empty p {
    color: #6c757d;
    margin-bottom: 30px;
}

.cart-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    margin-bottom: 30px;
}

.cart-table {
    margin: 0;
}

.cart-table thead {
    background: #f8f9fa;
}

.cart-table th {
    border: none;
    padding: 20px 15px;
    font-weight: 600;
    color: #495057;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.cart-table td {
    border: none;
    padding: 20px 15px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f3f4;
}

.cart-table tbody tr:last-child td {
    border-bottom: none;
}

.cart-table tbody tr:hover {
    background: #f8f9fa;
}

.product-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.product-name {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 5px;
}

.product-details {
    font-size: 0.9rem;
    color: #6c757d;
}

.quantity-input {
    width: 70px;
    padding: 8px 12px;
    border: 2px solid #e9ecef;
    border-radius: 6px;
    text-align: center;
    font-weight: 600;
    transition: border-color 0.3s;
}

.quantity-input:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
}

.price-text {
    font-weight: 700;
    color: #28a745;
    font-size: 1.1rem;
}

.total-price {
    font-weight: 700;
    color: #007bff;
    font-size: 1.2rem;
}

.delete-btn {
    color: #dc3545;
    font-size: 1.2rem;
    padding: 8px;
    border-radius: 50%;
    transition: all 0.3s;
    text-decoration: none;
}

.delete-btn:hover {
    background: #dc3545;
    color: white;
    text-decoration: none;
}

.cart-summary {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    padding: 30px;
    margin-bottom: 30px;
}

.cart-total-row {
    background: #f8f9fa;
    font-weight: 700;
    font-size: 1.2rem;
}

.cart-total-row td {
    padding: 25px 15px !important;
    color: #2c3e50;
}

.cart-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 30px;
}

.cart-btn {
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.cart-btn-primary {
    background: #007bff;
    color: white;
}

.cart-btn-primary:hover {
    background: #0056b3;
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,123,255,0.3);
}

.cart-btn-secondary {
    background: #6c757d;
    color: white;
}

.cart-btn-secondary:hover {
    background: #545b62;
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
}

.cart-btn-success {
    background: #28a745;
    color: white;
}

.cart-btn-success:hover {
    background: #1e7e34;
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(40,167,69,0.3);
}

@media (max-width: 768px) {
    .cart-table th:nth-child(1),
    .cart-table td:nth-child(1) {
        display: none;
    }
    
    .cart-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .cart-btn {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
    
    .product-image {
        width: 60px;
        height: 60px;
    }
}
</style>

<div class="page" style="padding: 40px 0; background: #f8fafc;">
	<div class="container">
		<div class="row">            
			<div class="col-md-12">
				<div class="page-header">
					<h1><?php echo LANG_VALUE_18; ?></h1>
					<p class="text-muted">Review your items and proceed to checkout</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">

		<?php if(!isset($_SESSION['cart_p_id']) || empty($_SESSION['cart_p_id'])): ?>
			<div class="cart-empty">
				<i class="fa fa-shopping-cart"></i>
				<h2>Your Cart is Empty</h2>
				<p>Looks like you haven't added any items to your cart yet. Start shopping to fill it up!</p>
				<a href="index.php" class="cart-btn cart-btn-primary">
					<i class="fa fa-shopping-bag"></i> Start Shopping
				</a>
			</div>
		<?php else: ?>
			<form action="" method="post">
				<?php $csrf->echoInputField(); ?>
				<div class="cart-container">
					<table class="table cart-table">
						<thead>
							<tr>
								<th>#</th>
								<th><?php echo LANG_VALUE_8; ?></th>
								<th><?php echo LANG_VALUE_47; ?></th>
								<th><?php echo LANG_VALUE_157; ?></th>
								<th><?php echo LANG_VALUE_158; ?></th>
								<th><?php echo LANG_VALUE_159; ?></th>
								<th><?php echo LANG_VALUE_55; ?></th>
								<th class="text-right"><?php echo LANG_VALUE_82; ?></th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
                        <?php
                        $table_total_price = 0;

                        $i=0;
                        foreach($_SESSION['cart_p_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_qty'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_qty[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_current_price'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_current_price[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_featured_photo'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_featured_photo[$i] = $value;
                        }
                        ?>
							<?php for($i=1;$i<=count($arr_cart_p_id);$i++): ?>
								<?php
								$row_total_price = $arr_cart_p_current_price[$i] * $arr_cart_p_qty[$i];
								$table_total_price += $row_total_price;
								?>
								<tr>
									<td><span class="badge badge-secondary"><?php echo $i; ?></span></td>
									<td>
										<img src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>" alt="<?php echo $arr_cart_p_name[$i]; ?>" class="product-image">
									</td>
									<td>
										<div class="product-name"><?php echo $arr_cart_p_name[$i]; ?></div>
									</td>
									<td><span class="badge badge-light"><?php echo $arr_cart_size_name[$i]; ?></span></td>
									<td><span class="badge badge-light"><?php echo $arr_cart_color_name[$i]; ?></span></td>
									<td><span class="price-text">₹<?php echo number_format((float)$arr_cart_p_current_price[$i]); ?></span></td>
									<td>
										<input type="hidden" name="product_id[]" value="<?php echo $arr_cart_p_id[$i]; ?>">
										<input type="hidden" name="product_name[]" value="<?php echo $arr_cart_p_name[$i]; ?>">
										<input type="number" class="quantity-input" step="1" min="1" max="" name="quantity[]" value="<?php echo $arr_cart_p_qty[$i]; ?>" title="Qty">
									</td>
									<td class="text-right"><span class="total-price">₹<?php echo number_format((float)$row_total_price); ?></span></td>
									<td class="text-center">
										<a href="cart-item-delete.php?id=<?php echo $arr_cart_p_id[$i]; ?>&size=<?php echo $arr_cart_size_id[$i]; ?>&color=<?php echo $arr_cart_color_id[$i]; ?>" class="delete-btn" title="Remove item">
											<i class="fa fa-trash"></i>
										</a>
									</td>
								</tr>
							<?php endfor; ?>
						</tbody>
						<tfoot>
							<tr class="cart-total-row">
								<td colspan="7" class="text-right"><strong>Total Amount:</strong></td>
								<td class="text-right"><strong>₹<?php echo number_format((float)$table_total_price); ?></strong></td>
								<td></td>
							</tr>
						</tfoot>
					</table>
				</div>

				<div class="cart-actions">
					<button type="submit" name="form1" class="cart-btn cart-btn-primary">
						<i class="fa fa-refresh"></i> <?php echo LANG_VALUE_20; ?>
					</button>
					<a href="index.php" class="cart-btn cart-btn-secondary">
						<i class="fa fa-shopping-bag"></i> <?php echo LANG_VALUE_85; ?>
					</a>
					<a href="checkout.php" class="cart-btn cart-btn-success">
						<i class="fa fa-credit-card"></i> <?php echo LANG_VALUE_23; ?>
					</a>
				</div>
			</form>
		<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var checkoutBtn = document.querySelector('.cart-btn-success[href="checkout.php"]');
  <?php if(!isset($_SESSION['customer']['cust_id'])): ?>
  if(checkoutBtn) {
    checkoutBtn.addEventListener('click', function(e) {
      e.preventDefault();
      alert('Please login to purchase.');
      window.location = 'login.php';
    });
  }
  <?php endif; ?>

  // Add smooth animations for quantity changes
  const quantityInputs = document.querySelectorAll('.quantity-input');
  quantityInputs.forEach(input => {
    input.addEventListener('change', function() {
      this.style.transform = 'scale(1.05)';
      setTimeout(() => {
        this.style.transform = 'scale(1)';
      }, 200);
    });
  });

  // Add confirmation for delete actions
  const deleteButtons = document.querySelectorAll('.delete-btn');
  deleteButtons.forEach(btn => {
    btn.addEventListener('click', function(e) {
      if (!confirm('Are you sure you want to remove this item from your cart?')) {
        e.preventDefault();
      }
    });
  });
});
</script>

<?php require_once('footer.php'); ?>
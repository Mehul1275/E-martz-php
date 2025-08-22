<?php require_once('header.php'); ?>

<section class="content-header">
    <div class="content-header-left">
        <h1>View Payments</h1>
    </div>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Product Details</th>
                    <th>Payment Information</th>
                    <th>Paid Amount</th>
                    <th>Payment Status</th>
                    <th>Shipping Status</th>
                    <th>Date</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i=0;
                $statement = $pdo->prepare("SELECT * FROM tbl_payment ORDER by id DESC");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    $i++;
                    ?>
                    <tr class="<?php if($row['payment_status']=='Pending'){echo 'bg-r';}else{echo 'bg-g';} ?>">
                        <td><?php echo $i; ?></td>
                        <td>
                            <b>Id:</b> <?php echo $row['customer_id']; ?><br>
                            <b>Name:</b> <?php echo $row['customer_name']; ?><br>
                            <b>Email:</b> <?php echo $row['customer_email']; ?><br>
                        </td>
                        <td>
                            <?php
                            $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                            $statement1->execute(array($row['payment_id']));
                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result1 as $row1) {
                                echo '<b>Product:</b> '.$row1['product_name'];
                                echo '<br>(<b>Size:</b> '.$row1['size'];
                                echo ', <b>Color:</b> '.$row1['color'].')';
                                echo '<br>(<b>Quantity:</b> '.$row1['quantity'];
                                echo ', <b>Unit Price:</b> '.$row1['unit_price'].')';
                                echo '<br><br>';
                            }
                            ?>
                        </td>
                        <td>
                            <?php if($row['payment_method'] == 'PayPal'): ?>
                                <b>Payment Method:</b> <?php echo '<span style="color:red;"><b>'.$row['payment_method'].'</b></span>'; ?><br>
                                <b>Payment Id:</b> <?php echo $row['payment_id']; ?><br>
                                <b>Transaction Id:</b> <?php echo $row['txnid']; ?><br>
                            <?php elseif($row['payment_method'] == 'Stripe'): ?>
                                <b>Payment Method:</b> <?php echo '<span style="color:red;"><b>'.$row['payment_method'].'</b></span>'; ?><br>
                                <b>Payment Id:</b> <?php echo $row['payment_id']; ?><br>
                                <b>Transaction Id:</b> <?php echo $row['txnid']; ?><br>
                                <b>Card Number:</b> <?php echo $row['card_number']; ?><br>
                                <b>Card CVV:</b> <?php echo $row['card_cvv']; ?><br>
                                <b>Expire Month:</b> <?php echo $row['card_month']; ?><br>
                                <b>Expire Year:</b> <?php echo $row['card_year']; ?><br>
                            <?php elseif($row['payment_method'] == 'Bank Deposit'): ?>
                                <b>Payment Method:</b> <?php echo '<span style="color:red;"><b>'.$row['payment_method'].'</b></span>'; ?><br>
                                <b>Payment Id:</b> <?php echo $row['payment_id']; ?><br>
                                <b>Transaction Information:</b> <br><?php echo $row['bank_transaction_info']; ?><br>
                            <?php endif; ?>
                        </td>
                        <td>₹<?php echo $row['paid_amount']; ?></td>
                        <td><?php echo $row['payment_status']; ?></td>
                        <td><?php echo $row['shipping_status']; ?></td>
                        <td><?php echo $row['payment_date']; ?></td>
                        <td><?php echo $row['invoice_number']; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once('footer.php'); ?> 
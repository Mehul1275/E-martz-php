<?php require_once('header.php'); ?>
<title> E-martz | Track your Order </title>

<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header" style="margin-bottom: 30px;">
                    <h1>Track Your Order</h1>
                    <p class="text-muted">Enter your tracking ID or invoice number to track your order status</p>
                </div>
                
                <div class="track-container" style="background:#fff; padding: 30px 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <div class="track-intro" style="text-align: center; margin-bottom: 40px; padding: 30px; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-radius: 12px;">
                        <i class="fa fa-search" style="font-size: 48px; color: var(--color-primary); margin-bottom: 15px;"></i>
                        <h2 style="color: var(--color-neutral-900); margin-bottom: 10px;">Track Your Order</h2>
                        <p style="color: var(--color-neutral-600); margin: 0; font-size: 16px;">Enter your tracking ID or invoice number to get real-time updates on your order</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="track-card" style="background: #fff; border: 1px solid var(--color-neutral-200); border-radius: 12px; padding: 25px; margin-bottom: 20px; height: 100%;">
                                <div class="card-header" style="text-align: center; margin-bottom: 20px;">
                                    <i class="fa fa-barcode" style="font-size: 32px; color: var(--color-primary); margin-bottom: 10px;"></i>
                                    <h4 style="color: var(--color-neutral-900); margin: 0;">Track by Tracking ID</h4>
                                </div>
                                <form method="post" action="">
                                    <div class="form-group" style="margin-bottom: 20px;">
                                        <label for="tracking_id" style="font-weight: 600; color: var(--color-neutral-700); margin-bottom: 8px; display: block;">
                                            <i class="fa fa-tag" style="margin-right: 8px;"></i>Tracking ID:
                                        </label>
                                        <input type="text" name="tracking_id" id="tracking_id" class="form-control" 
                                               placeholder="Enter your tracking ID" required
                                               style="padding: 12px 15px; border: 2px solid var(--color-neutral-200); border-radius: 8px; font-size: 16px;">
                                    </div>
                                    <button type="submit" name="track_by_id" class="btn btn-primary btn-lg" 
                                            style="width: 100%; padding: 12px; font-weight: 600;">
                                        <i class="fa fa-search"></i> Track Order
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="track-card" style="background: #fff; border: 1px solid var(--color-neutral-200); border-radius: 12px; padding: 25px; margin-bottom: 20px; height: 100%;">
                                <div class="card-header" style="text-align: center; margin-bottom: 20px;">
                                    <i class="fa fa-file-text" style="font-size: 32px; color: var(--color-primary); margin-bottom: 10px;"></i>
                                    <h4 style="color: var(--color-neutral-900); margin: 0;">Track by Invoice Number</h4>
                                </div>
                                <form method="post" action="">
                                    <div class="form-group" style="margin-bottom: 20px;">
                                        <label for="invoice_number" style="font-weight: 600; color: var(--color-neutral-700); margin-bottom: 8px; display: block;">
                                            <i class="fa fa-receipt" style="margin-right: 8px;"></i>Invoice Number:
                                        </label>
                                        <input type="text" name="invoice_number" id="invoice_number" class="form-control" 
                                               placeholder="Enter your invoice number" required
                                               style="padding: 12px 15px; border: 2px solid var(--color-neutral-200); border-radius: 8px; font-size: 16px;">
                                    </div>
                                    <button type="submit" name="track_by_invoice" class="btn btn-primary btn-lg" 
                                            style="width: 100%; padding: 12px; font-weight: 600;">
                                        <i class="fa fa-search"></i> Track Order
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php
                    // Check for URL parameters first
                    $tracking_id = '';
                    $invoice_number = '';
                    
                    if(isset($_GET['tracking_id'])) {
                        $tracking_id = trim($_GET['tracking_id']);
                    } elseif(isset($_GET['invoice_number'])) {
                        $invoice_number = trim($_GET['invoice_number']);
                    } elseif(isset($_POST['track_by_id']) || isset($_POST['track_by_invoice'])) {
                        if(isset($_POST['track_by_id'])) {
                            $tracking_id = trim($_POST['tracking_id']);
                        } else {
                            $invoice_number = trim($_POST['invoice_number']);
                        }
                    }
                        
                    if(!empty($tracking_id) || !empty($invoice_number)) {
                        $where_clause = '';
                        $params = array();
                        
                        if(!empty($tracking_id)) {
                            $where_clause = "tracking_id = ?";
                            $params[] = $tracking_id;
                        } else {
                            $where_clause = "invoice_number = ?";
                            $params[] = $invoice_number;
                        }
                        
                        $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE $where_clause");
                        $statement->execute($params);
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        
                        if(count($result) > 0) {
                            foreach($result as $row) {
                                ?>
                                <div class="order-results" style="margin-top: 40px;">
                                    <div class="result-header" style="text-align: center; margin-bottom: 30px; padding: 20px; background: #ecfdf5; border-radius: 12px; border: 1px solid #a7f3d0;">
                                        <i class="fa fa-check-circle" style="font-size: 48px; color: #059669; margin-bottom: 10px;"></i>
                                        <h3 style="color: #065f46; margin: 0;">Order Found!</h3>
                                        <p style="color: #065f46; margin: 5px 0 0 0;">Here are the details of your order</p>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="order-details-card" style="background: #fff; border: 1px solid var(--color-neutral-200); border-radius: 12px; padding: 25px; margin-bottom: 20px;">
                                                <h4 style="color: var(--color-primary); margin-bottom: 20px; border-bottom: 2px solid var(--color-neutral-200); padding-bottom: 10px;">
                                                    <i class="fa fa-info-circle"></i> Order Information
                                                </h4>
                                                <div class="info-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                                    <div class="info-item" style="padding: 15px; background: var(--color-neutral-50); border-radius: 8px;">
                                                        <strong style="color: var(--color-neutral-900); display: block; margin-bottom: 5px;">Tracking ID:</strong>
                                                        <span style="color: var(--color-neutral-700); font-family: monospace;"><?php echo $row['tracking_id']; ?></span>
                                                    </div>
                                                    <div class="info-item" style="padding: 15px; background: var(--color-neutral-50); border-radius: 8px;">
                                                        <strong style="color: var(--color-neutral-900); display: block; margin-bottom: 5px;">Invoice Number:</strong>
                                                        <span style="color: var(--color-neutral-700); font-family: monospace;"><?php echo $row['invoice_number']; ?></span>
                                                    </div>
                                                    <div class="info-item" style="padding: 15px; background: var(--color-neutral-50); border-radius: 8px;">
                                                        <strong style="color: var(--color-neutral-900); display: block; margin-bottom: 5px;">Order Date:</strong>
                                                        <span style="color: var(--color-neutral-700);"><?php echo date('M d, Y', strtotime($row['payment_date'])); ?></span>
                                                    </div>
                                                    <div class="info-item" style="padding: 15px; background: var(--color-neutral-50); border-radius: 8px;">
                                                        <strong style="color: var(--color-neutral-900); display: block; margin-bottom: 5px;">Total Amount:</strong>
                                                        <span style="color: var(--color-primary); font-weight: 600; font-size: 18px;">₹<?php echo $row['paid_amount']; ?></span>
                                                    </div>
                                                    <div class="info-item" style="padding: 15px; background: var(--color-neutral-50); border-radius: 8px;">
                                                        <strong style="color: var(--color-neutral-900); display: block; margin-bottom: 5px;">Customer Name:</strong>
                                                        <span style="color: var(--color-neutral-700);"><?php echo $row['customer_name']; ?></span>
                                                    </div>
                                                    <div class="info-item" style="padding: 15px; background: var(--color-neutral-50); border-radius: 8px;">
                                                        <strong style="color: var(--color-neutral-900); display: block; margin-bottom: 5px;">Payment Method:</strong>
                                                        <span style="color: var(--color-neutral-700);"><?php echo $row['payment_method']; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="status-card" style="background: #fff; border: 1px solid var(--color-neutral-200); border-radius: 12px; padding: 25px; margin-bottom: 20px;">
                                                <h4 style="color: var(--color-primary); margin-bottom: 20px; text-align: center;">
                                                    <i class="fa fa-truck"></i> Order Status
                                                </h4>
                                                
                                                <div class="status-timeline">
                                                    <div class="timeline-item <?php echo ($row['payment_status'] == 'Completed') ? 'completed' : 'pending'; ?>" 
                                                         style="display: flex; align-items: center; margin-bottom: 20px; padding: 15px; border-radius: 8px; <?php echo ($row['payment_status'] == 'Completed') ? 'background: #ecfdf5; border: 1px solid #a7f3d0;' : 'background: #fef3c7; border: 1px solid #fde68a;'; ?>">
                                                        <i class="fa fa-credit-card" style="font-size: 20px; margin-right: 15px; <?php echo ($row['payment_status'] == 'Completed') ? 'color: #059669;' : 'color: #d97706;'; ?>"></i>
                                                        <div>
                                                            <strong style="display: block; <?php echo ($row['payment_status'] == 'Completed') ? 'color: #065f46;' : 'color: #92400e;'; ?>">Payment <?php echo $row['payment_status']; ?></strong>
                                                            <small style="<?php echo ($row['payment_status'] == 'Completed') ? 'color: #065f46;' : 'color: #92400e;'; ?>"><?php echo date('M d, Y', strtotime($row['payment_date'])); ?></small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="timeline-item <?php echo ($row['shipping_status'] == 'Completed') ? 'completed' : 'pending'; ?>" 
                                                         style="display: flex; align-items: center; margin-bottom: 20px; padding: 15px; border-radius: 8px; <?php echo ($row['shipping_status'] == 'Completed') ? 'background: #ecfdf5; border: 1px solid #a7f3d0;' : 'background: #fef3c7; border: 1px solid #fde68a;'; ?>">
                                                        <i class="fa fa-truck" style="font-size: 20px; margin-right: 15px; <?php echo ($row['shipping_status'] == 'Completed') ? 'color: #059669;' : 'color: #d97706;'; ?>"></i>
                                                        <div>
                                                            <strong style="display: block; <?php echo ($row['shipping_status'] == 'Completed') ? 'color: #065f46;' : 'color: #92400e;'; ?>">
                                                                <?php echo ($row['shipping_status'] == 'Completed') ? 'Delivered' : 'In Transit'; ?>
                                                            </strong>
                                                            <small style="<?php echo ($row['shipping_status'] == 'Completed') ? 'color: #065f46;' : 'color: #92400e;'; ?>">
                                                                <?php echo ($row['shipping_status'] == 'Completed') ? 'Order delivered' : 'Processing shipment'; ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="action-center" style="text-align: center; margin-top: 20px;">
                                                    <a href="invoice.php?payment_id=<?php echo $row['payment_id']; ?>" 
                                                       class="btn btn-outline" target="_blank" style="width: 100%; margin-bottom: 10px;">
                                                        <i class="fa fa-file-pdf-o"></i> View Invoice
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="order-items-card" style="background: #fff; border: 1px solid var(--color-neutral-200); border-radius: 12px; padding: 25px; margin-top: 20px;">
                                        <h4 style="color: var(--color-primary); margin-bottom: 20px; border-bottom: 2px solid var(--color-neutral-200); padding-bottom: 10px;">
                                            <i class="fa fa-shopping-bag"></i> Order Items
                                        </h4>
                                        <div class="table-responsive">
                                            <table class="table" style="margin: 0;">
                                                <thead style="background: var(--color-neutral-50);">
                                                    <tr>
                                                        <th style="border: none; padding: 15px; font-weight: 600;">Product</th>
                                                        <th style="border: none; padding: 15px; font-weight: 600;">Size</th>
                                                        <th style="border: none; padding: 15px; font-weight: 600;">Color</th>
                                                        <th style="border: none; padding: 15px; font-weight: 600;">Qty</th>
                                                        <th style="border: none; padding: 15px; font-weight: 600;">Price</th>
                                                        <th style="border: none; padding: 15px; font-weight: 600;">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                                                    $statement1->execute(array($row['payment_id']));
                                                    $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result1 as $row1) {
                                                        ?>
                                                        <tr>
                                                            <td style="padding: 15px; border-bottom: 1px solid var(--color-neutral-200); font-weight: 500;"><?php echo $row1['product_name']; ?></td>
                                                            <td style="padding: 15px; border-bottom: 1px solid var(--color-neutral-200);"><?php echo $row1['size']; ?></td>
                                                            <td style="padding: 15px; border-bottom: 1px solid var(--color-neutral-200);"><?php echo $row1['color']; ?></td>
                                                            <td style="padding: 15px; border-bottom: 1px solid var(--color-neutral-200); text-align: center;"><?php echo $row1['quantity']; ?></td>
                                                            <td style="padding: 15px; border-bottom: 1px solid var(--color-neutral-200);">₹<?php echo $row1['unit_price']; ?></td>
                                                            <td style="padding: 15px; border-bottom: 1px solid var(--color-neutral-200); font-weight: 600; color: var(--color-primary);">₹<?php echo $row1['quantity'] * $row1['unit_price']; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="no-results" style="margin-top: 40px; text-align: center; padding: 40px; background: #fef2f2; border-radius: 12px; border: 1px solid #fecaca;">
                                <i class="fa fa-exclamation-triangle" style="font-size: 48px; color: #dc2626; margin-bottom: 15px;"></i>
                                <h3 style="color: #991b1b; margin-bottom: 10px;">No Order Found!</h3>
                                <p style="color: #991b1b; margin-bottom: 20px;">Please check your tracking ID or invoice number and try again.</p>
                                <a href="contact.php" class="btn btn-primary">
                                    <i class="fa fa-envelope"></i> Contact Support
                                </a>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    
                    <div class="track-help" style="margin-top: 40px; padding: 25px; background: #f8fafc; border-radius: 12px; text-align: center;">
                        <h4 style="margin-bottom: 15px; color: var(--color-neutral-900);"><i class="fa fa-question-circle"></i> Need Help Tracking?</h4>
                        <p style="color: var(--color-neutral-600); margin-bottom: 20px;">
                            Can't find your tracking information? Check your email for order confirmation or contact our support team.
                        </p>
                        <div class="help-actions">
                            <a href="help.php" class="btn btn-outline" style="margin-right: 15px;">
                                <i class="fa fa-life-ring"></i> Help Center
                            </a>
                            <a href="contact.php" class="btn btn-primary">
                                <i class="fa fa-envelope"></i> Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
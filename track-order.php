<?php require_once('header.php'); ?>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <h3>Track Your Order</h3>
                    <p>Enter your tracking ID or invoice number to track your order status.</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4>Track by Tracking ID</h4>
                                </div>
                                <div class="panel-body">
                                    <form method="post" action="">
                                        <div class="form-group">
                                            <label for="tracking_id">Tracking ID:</label>
                                            <input type="text" name="tracking_id" id="tracking_id" class="form-control" placeholder="Enter your tracking ID" required>
                                        </div>
                                        <button type="submit" name="track_by_id" class="btn btn-primary">Track Order</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4>Track by Invoice Number</h4>
                                </div>
                                <div class="panel-body">
                                    <form method="post" action="">
                                        <div class="form-group">
                                            <label for="invoice_number">Invoice Number:</label>
                                            <input type="text" name="invoice_number" id="invoice_number" class="form-control" placeholder="Enter your invoice number" required>
                                        </div>
                                        <button type="submit" name="track_by_invoice" class="btn btn-primary">Track Order</button>
                                    </form>
                                </div>
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
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4>Order Details</h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5>Order Information</h5>
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td><strong>Tracking ID:</strong></td>
                                                            <td><?php echo $row['tracking_id']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Invoice Number:</strong></td>
                                                            <td><?php echo $row['invoice_number']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Order Date:</strong></td>
                                                            <td><?php echo $row['payment_date']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Customer Name:</strong></td>
                                                            <td><?php echo $row['customer_name']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Customer Email:</strong></td>
                                                            <td><?php echo $row['customer_email']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Payment Method:</strong></td>
                                                            <td><?php echo $row['payment_method']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Total Amount:</strong></td>
                                                            <td>₹<?php echo $row['paid_amount']; ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5>Order Status</h5>
                                                    <div class="order-status">
                                                        <div class="status-item <?php echo ($row['payment_status'] == 'Completed') ? 'completed' : 'pending'; ?>">
                                                            <i class="fa fa-credit-card"></i>
                                                            <span>Payment Status: <?php echo $row['payment_status']; ?></span>
                                                        </div>
                                                        <div class="status-item <?php echo ($row['shipping_status'] == 'Completed') ? 'completed' : 'pending'; ?>">
                                                            <i class="fa fa-truck"></i>
                                                            <span>Shipping Status: <?php echo $row['shipping_status']; ?></span>
                                                        </div>
                                                    </div>
                                                    
                                                    <h5>Order Timeline</h5>
                                                    <div class="timeline">
                                                        <div class="timeline-item completed">
                                                            <div class="timeline-marker"></div>
                                                            <div class="timeline-content">
                                                                <h6>Order Placed</h6>
                                                                <p><?php echo $row['payment_date']; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="timeline-item <?php echo ($row['payment_status'] == 'Completed') ? 'completed' : 'pending'; ?>">
                                                            <div class="timeline-marker"></div>
                                                            <div class="timeline-content">
                                                                <h6>Payment <?php echo ($row['payment_status'] == 'Completed') ? 'Completed' : 'Pending'; ?></h6>
                                                                <p><?php echo $row['payment_date']; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="timeline-item <?php echo ($row['shipping_status'] == 'Completed') ? 'completed' : 'pending'; ?>">
                                                            <div class="timeline-marker"></div>
                                                            <div class="timeline-content">
                                                                <h6>Order <?php echo ($row['shipping_status'] == 'Completed') ? 'Delivered' : 'In Transit'; ?></h6>
                                                                <p><?php echo ($row['shipping_status'] == 'Completed') ? 'Delivered' : 'Processing'; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <h5>Order Items</h5>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Product Name</th>
                                                            <th>Size</th>
                                                            <th>Color</th>
                                                            <th>Quantity</th>
                                                            <th>Unit Price</th>
                                                            <th>Total</th>
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
                                                                <td><?php echo $row1['product_name']; ?></td>
                                                                <td><?php echo $row1['size']; ?></td>
                                                                <td><?php echo $row1['color']; ?></td>
                                                                <td><?php echo $row1['quantity']; ?></td>
                                                                <td>₹<?php echo $row1['unit_price']; ?></td>
                                                                <td>₹<?php echo $row1['quantity'] * $row1['unit_price']; ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <div class="text-center">
                                                <a href="invoice.php?payment_id=<?php echo $row['payment_id']; ?>" class="btn btn-info" target="_blank">View Invoice</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="alert alert-warning">
                                    <strong>No order found!</strong> Please check your tracking ID or invoice number and try again.
                                </div>
                                <?php
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.order-status {
    margin-bottom: 20px;
}

.status-item {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    border-left: 4px solid #ddd;
}

.status-item.completed {
    background-color: #d4edda;
    border-left-color: #28a745;
}

.status-item.pending {
    background-color: #fff3cd;
    border-left-color: #ffc107;
}

.status-item i {
    margin-right: 10px;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #ddd;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #ddd;
    border: 2px solid #fff;
}

.timeline-item.completed .timeline-marker {
    background-color: #28a745;
}

.timeline-item.pending .timeline-marker {
    background-color: #ffc107;
}

.timeline-content {
    padding-left: 20px;
}

.timeline-content h6 {
    margin: 0 0 5px 0;
    font-weight: bold;
}

.timeline-content p {
    margin: 0;
    color: #666;
    font-size: 12px;
}
</style>

<?php require_once('footer.php'); ?> 
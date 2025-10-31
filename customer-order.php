<?php require_once('header.php'); ?>
<?php require_once('admin/inc/tracking_functions.php'); ?>

<?php
// Check if the customer is logged in or not
if(!isset($_SESSION['customer'])) {
    header('location: '.BASE_URL.'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'],0));
    $total = $statement->rowCount();
    if($total) {
        header('location: '.BASE_URL.'logout.php');
        exit;
    }
}
?>

<div class="page" style="padding-top: 25px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php require_once('customer-sidebar.php'); ?>
            </div>
            <div class="col-md-12">
                <div class="user-content">
                    <h3 class="simple-page-title"><?php echo LANG_VALUE_25; ?></h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo '#' ?></th>
                                    <th><?php echo LANG_VALUE_48; ?></th>
                                    <th><?php echo LANG_VALUE_27; ?></th>
                                    <th><?php echo LANG_VALUE_28; ?></th>
                                    <th><?php echo LANG_VALUE_29; ?></th>
                                    <th><?php echo LANG_VALUE_30; ?></th>
                                    <th><?php echo LANG_VALUE_31; ?></th>
                                    <th>Shipping Status</th>
                                    <th>Tracking ID</th>
                                    <th>Invoice</th>
                                    <th>Order Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>


            <?php
            /* ===================== Pagination Code Starts ================== */
            $adjacents = 5;

            $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE customer_email=? ORDER BY id DESC");
            $statement->execute(array($_SESSION['customer']['cust_email']));
            $total_pages = $statement->rowCount();

            $targetpage = BASE_URL.'customer-order.php';
            $limit = 10;
            $page = @$_GET['page'];
            if($page) 
                $start = ($page - 1) * $limit;
            else
                $start = 0;
            
            
            $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE customer_email=? ORDER BY id DESC LIMIT $start, $limit");
            $statement->execute(array($_SESSION['customer']['cust_email']));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
           
            
            if ($page == 0) $page = 1;
            $prev = $page - 1;
            $next = $page + 1;
            $lastpage = ceil($total_pages/$limit);
            $lpm1 = $lastpage - 1;   
            $pagination = "";
            if($lastpage > 1)
            {   
                $pagination .= "<div class=\"pagination\">";
                if ($page > 1) 
                    $pagination.= "<a href=\"$targetpage?page=$prev\">&#171; previous</a>";
                else
                    $pagination.= "<span class=\"disabled\">&#171; previous</span>";    
                if ($lastpage < 7 + ($adjacents * 2))
                {   
                    for ($counter = 1; $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class=\"current\">$counter</span>";
                        else
                            $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
                    }
                }
                elseif($lastpage > 5 + ($adjacents * 2))
                {
                    if($page < 1 + ($adjacents * 2))        
                    {
                        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
                        }
                        $pagination.= "...";
                        $pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
                        $pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
                    }
                    elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                    {
                        $pagination.= "<a href=\"$targetpage?page=1\">1</a>";
                        $pagination.= "<a href=\"$targetpage?page=2\">2</a>";
                        $pagination.= "...";
                        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
                        }
                        $pagination.= "...";
                        $pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
                        $pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
                    }
                    else
                    {
                        $pagination.= "<a href=\"$targetpage?page=1\">1</a>";
                        $pagination.= "<a href=\"$targetpage?page=2\">2</a>";
                        $pagination.= "...";
                        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
                        }
                    }
                }
                if ($page < $counter - 1) 
                    $pagination.= "<a href=\"$targetpage?page=$next\">next &#187;</a>";
                else
                    $pagination.= "<span class=\"disabled\">next &#187;</span>";
                $pagination.= "</div>\n";       
            } 
            /* ===================== Pagination Code Ends ================== */
            ?>


                                <?php
                                $tip = $page*10-10;
                                foreach ($result as $row) {
                                    $tip++;
                                    ?>
                                    <tr>
                                        <td><?php echo $tip; ?></td>
                                        <td>
                                            <?php
                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                                            $statement1->execute(array($row['payment_id']));
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result1 as $row1) {
                                                echo 'Product Name: '.$row1['product_name'];
                                                echo '<br>Size: '.$row1['size'];
                                                echo '<br>Color: '.$row1['color'];
                                                echo '<br>Quantity: '.$row1['quantity'];
                                                echo '<br>Unit Price: ₹'.$row1['unit_price'];
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $row['payment_date']; ?></td>
                                        <td><?php echo $row['txnid']; ?></td>
                                        <td>₹<?php echo $row['paid_amount']; ?></td>
                                        <td><?php
                                            $order_status = isset($row['order_status']) ? $row['order_status'] : 'Pending';
                                            echo in_array($order_status, ['Cancelled','Returned']) ? '' : $row['payment_status'];
                                        ?></td>
                                        <td><?php echo $row['payment_method']; ?></td>
                                        <td><?php
                                            $order_status = isset($row['order_status']) ? $row['order_status'] : 'Pending';
                                            echo in_array($order_status, ['Cancelled','Returned']) ? '' : $row['shipping_status'];
                                        ?></td>
                                        <td><?php echo $row['tracking_id']; ?></td>
                                        <td><?php echo $row['invoice_number']; ?></td>
                                        <td>
                                            <?php
                                            // Display order status with colored badges
                                            $order_status = isset($row['order_status']) ? $row['order_status'] : 'Pending';
                                            $status_class = '';
                                            switch($order_status) {
                                                case 'Pending': $status_class = 'label-warning'; break;
                                                case 'Confirmed': $status_class = 'label-info'; break;
                                                case 'Shipped': $status_class = 'label-primary'; break;
                                                case 'Delivered': $status_class = 'label-success'; break;
                                                case 'Cancelled': $status_class = 'label-danger'; break;
                                                case 'Returned': $status_class = 'label-warning'; break;
                                                default: $status_class = 'label-default';
                                            }
                                            echo '<span class="label ' . $status_class . '">' . $order_status . '</span>';
                                            
                                            // Show return approval status if returned
                                            if($order_status == 'Returned') {
                                                $approval_status = $row['return_approved_by_admin'] ? 'Approved' : 'Pending Approval';
                                                $approval_class = $row['return_approved_by_admin'] ? 'label-success' : 'label-warning';
                                                echo '<br><small><span class="label ' . $approval_class . '">' . $approval_status . '</span></small>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $order_status = isset($row['order_status']) ? $row['order_status'] : 'Pending';
                                            
                                            // If order is cancelled or returned, show only a message (no actions)
                                            if(in_array($order_status, ['Cancelled','Returned'])) {
                                                if($order_status == 'Cancelled') {
                                                    echo '<div class="alert alert-danger" style="margin:0; padding:8px; text-align:center;">';
                                                    echo '<strong>Order Cancelled</strong><br>';
                                                    if(!empty($row['cancel_reason'])) {
                                                        echo '<small>Reason: ' . htmlspecialchars($row['cancel_reason']) . '</small>';
                                                    }
                                                    echo '</div>';
                                                } else { // Returned
                                                    echo '<div class="alert alert-warning" style="margin:0; padding:8px; text-align:center;">';
                                                    echo '<strong>Order Returned</strong><br>';
                                                    if(!empty($row['return_reason'])) {
                                                        echo '<small>Reason: ' . htmlspecialchars($row['return_reason']) . '</small><br>';
                                                    }
                                                    $approval_text = isset($row['return_approved_by_admin']) && $row['return_approved_by_admin'] ? 'Approved' : 'Pending Approval';
                                                    echo '<small>Status: ' . $approval_text . '</small>';
                                                    echo '</div>';
                                                }
                                            } else {
                                                // Show normal action buttons for non-cancelled orders
                                                
                                                // Show invoice button only when payment is completed
                                                if($row['payment_status'] == 'Completed') {
                                                    echo '<a href="invoice.php?payment_id='.$row['payment_id'].'" class="btn btn-info btn-sm" target="_blank" style="width:100%;margin-bottom:4px;">View Invoice</a>';
                                                }
                                                
                                                // Show track order button only if shipping is not completed
                                                if(!empty($row['tracking_id']) && $row['shipping_status'] != 'Completed') {
                                                    echo '<a href="track-order.php?tracking_id='.$row['tracking_id'].'" class="btn btn-success btn-sm" target="_blank" style="width:100%;margin-bottom:4px;">Track Order</a>';
                                                }
                                                
                                                $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                                                $statement1->execute(array($row['payment_id']));
                                                $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result1 as $row1) {
                                                    // Check if user has already reviewed this product
                                                    $statement2 = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=? AND cust_id=?");
                                                    $statement2->execute(array($row1['product_id'], $_SESSION['customer']['cust_id']));
                                                    $hasReviewed = $statement2->rowCount();
                                                    
                                                    // Show review button only if user hasn't reviewed this product
                                                    if($hasReviewed == 0) {
                                                        echo '<a href="product.php?id='.$row1['product_id'].'#review-section" class="btn btn-primary btn-sm" style="color: white; width:100%;margin-bottom:4px;">Review</a>';
                                                    }
                                                }
                                                
                                                // Cancel Order Button (show only for Pending or Confirmed orders)
                                                if(in_array($order_status, ['Pending', 'Confirmed'])) {
                                                    echo '<button class="btn btn-warning btn-sm cancel-order-btn" data-order-id="'.$row['id'].'" style="width:100%;margin-bottom:4px;">Cancel Order</button>';
                                                }
                                                
                                                // Return Order Button (show only for Delivered orders)
                                                if($order_status == 'Delivered') {
                                                    echo '<button class="btn btn-danger btn-sm return-order-btn" data-order-id="'.$row['id'].'" style="width:100%;margin-bottom:4px;">Return Order</button>';
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    
                                    <?php
                                } 
                                ?>                               
                                
                            </tbody>
                        </table>
                        <div class="pagination" style="overflow: hidden;">
                        <?php 
                            echo $pagination; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Styles for Order Actions -->
<style>
.modal .help-text { font-size: 12px; color: #6c757d; }
.modal .char-counter { font-size: 12px; float: right; }
</style>

<!-- Modal HTML -->
<div class="modal fade" id="orderActionModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Order Action</h4>
      </div>
      <form id="orderActionForm">
        <div class="modal-body">
          <div id="orderActionInfo" class="alert" style="display:none;"></div>
          <div class="form-group" id="reasonGroup">
            <label id="reasonLabel" for="orderActionReason">Reason</label>
            <textarea id="orderActionReason" class="form-control" rows="4" placeholder="Type your reason here..."></textarea>
            <div class="help-text"><span class="char-counter" id="charCounter">0</span></div>
          </div>
          <input type="hidden" id="orderActionId" value="">
          <input type="hidden" id="orderActionType" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="orderActionSubmit">Submit</button>
        </div>
      </form>
    </div>
  </div>
  </div>

<!-- JavaScript for Modal-based Order Actions -->
<script>
$(document).ready(function() {
  function showNotification(type, message) {
    var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    var notification = $('<div class="alert ' + alertClass + ' alert-dismissible" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
      '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
      '<strong>' + (type === 'success' ? 'Success!' : 'Error!') + '</strong> ' + message +
      '</div>');
    $('body').append(notification);
    setTimeout(function(){ notification.fadeOut(function(){ $(this).remove(); }); }, 5000);
  }

  // Open modal for Cancel
  $('.cancel-order-btn').on('click', function(){
    var orderId = $(this).data('order-id');
    $('#orderActionId').val(orderId);
    $('#orderActionType').val('cancel');
    $('.modal-title').text('Cancel Order');
    $('#orderActionInfo').removeClass('alert-info alert-warning').addClass('alert-warning').text('Warning: This action cannot be undone.').show();
    $('#reasonLabel').text('Reason for cancellation (optional)');
    $('#orderActionReason').val('').attr('placeholder','Please provide a reason for cancellation (optional)').removeClass('is-invalid');
    $('#charCounter').text('0');
    $('#orderActionSubmit').removeClass('btn-warning').addClass('btn-danger').text('Cancel Order');
    $('#orderActionModal').modal('show');
  });

  // Open modal for Return
  $('.return-order-btn').on('click', function(){
    var orderId = $(this).data('order-id');
    $('#orderActionId').val(orderId);
    $('#orderActionType').val('return');
    $('.modal-title').text('Return Order');
    $('#orderActionInfo').removeClass('alert-warning alert-info').addClass('alert-info').text('Please provide a detailed reason. Your request will be reviewed.').show();
    $('#reasonLabel').html('Return Reason <span class="text-danger">*</span>');
    $('#orderActionReason').val('').attr('placeholder','e.g., defective product, wrong item, damaged package, etc.').removeClass('is-invalid');
    $('#charCounter').text('0');
    $('#orderActionSubmit').removeClass('btn-danger').addClass('btn-warning').text('Submit Return Request');
    $('#orderActionModal').modal('show');
  });

  // Character counter for reason
  $('#orderActionReason').on('input', function(){
    $('#charCounter').text($(this).val().trim().length);
  });

  // Submit handler
  $('#orderActionForm').on('submit', function(e){
    e.preventDefault();
    var type = $('#orderActionType').val();
    var orderId = $('#orderActionId').val();
    var reason = $('#orderActionReason').val().trim();

    if(type === 'return' && reason.length < 10){
      $('#orderActionReason').addClass('is-invalid');
      showNotification('error','Please provide a detailed return reason (minimum 10 characters).');
      return;
    }

    var url = type === 'cancel' ? 'cancel-order.php' : 'return-order.php';
    var data = { order_id: orderId };
    if(type === 'cancel') data.cancel_reason = reason; else data.return_reason = reason;

    $('#orderActionSubmit').prop('disabled', true).text('Processing...');

    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      dataType: 'json',
      success: function(response){
        if(response.success){
          $('#orderActionModal').modal('hide');
          showNotification('success', response.message);
          setTimeout(function(){ location.reload(); }, 1200);
        } else {
          showNotification('error', response.message || 'Request failed.');
          $('#orderActionSubmit').prop('disabled', false).text(type === 'cancel' ? 'Cancel Order' : 'Submit Return Request');
        }
      },
      error: function(){
        showNotification('error','An error occurred while processing your request.');
        $('#orderActionSubmit').prop('disabled', false).text(type === 'cancel' ? 'Cancel Order' : 'Submit Return Request');
      }
    });
  });
});
</script>

<?php require_once('footer.php'); ?>

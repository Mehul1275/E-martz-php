<?php
// Handle AJAX request for message (must be before any output)
if(isset($_POST['get_message']) && isset($_POST['id'])) {
    require_once('inc/config.php'); // Ensure $pdo is available
    $id = (int)$_POST['id'];
    // Mark as read
    $stmt = $pdo->prepare("UPDATE tbl_contact_messages SET is_read=1 WHERE id=?");
    $stmt->execute([$id]);
    // Get message
    $stmt = $pdo->prepare("SELECT message FROM tbl_contact_messages WHERE id=?");
    $stmt->execute([$id]);
    $msg = $stmt->fetch(PDO::FETCH_ASSOC);
    $message_html = $msg ? nl2br(htmlspecialchars($msg['message'])) : 'Message not found.';
    echo json_encode(['success'=>true, 'message_html'=>$message_html]);
    exit;
}
?>
<?php require_once('header.php'); ?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Contact Messages</h1>
    </div>
</section>
 
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php
            // Handle delete
            if (isset($_GET['delete']) && isset($_GET['id'])) {
                $id = (int)$_GET['id'];
                $stmt = $pdo->prepare("DELETE FROM tbl_contact_messages WHERE id=?");
                $stmt->execute([$id]);
                echo '<div class="alert alert-success">Message deleted.</div>';
            }
            ?>
            <div class="box box-info">
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped" id="messages-table">
                        <thead>
                            <tr>
                                <!-- <th>ID</th> -->
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM tbl_contact_messages ORDER BY created_at DESC");
                        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($messages as $msg):
                        ?>
                            <tr style="background-color:<?php echo $msg['is_read'] ? '#fff' : '#fffbe6'; ?>;">
                                <!-- <td><?php echo $msg['id']; ?></td> -->
                                <td><?php echo htmlspecialchars($msg['name']); ?></td>
                                <td><?php echo htmlspecialchars($msg['email']); ?></td>
                                <td><?php echo htmlspecialchars($msg['phone']); ?></td>
                                <td><?php echo $msg['created_at']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-xs btn-info show-message-btn" data-id="<?php echo $msg['id']; ?>">Show</button>
                                    <a href="?delete=1&id=<?php echo $msg['id']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="messageModalLabel">Message</h4>
      </div>
      <div class="modal-body" id="modal-message-content">
        <!-- Message will be loaded here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<link rel="stylesheet" href="css/dataTables.bootstrap.css">
<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>

<script>
// jQuery required
$(document).ready(function() {
    $(".show-message-btn").click(function(e) {
        e.stopPropagation();
        var btn = $(this);
        var id = btn.data('id');
        var row = btn.closest('tr');

        // Disable button and show loading text
        btn.prop('disabled', true).text('Loading...');

        // Show loading message in modal
        $("#modal-message-content").html('<p>Loading message...</p>');
        $("#messageModal").modal('show');

        // AJAX to get message and mark as read
        $.ajax({
            url: 'messages.php',
            type: 'POST',
            data: { get_message: 1, id: id },
            dataType: 'json',
            success: function(data) {
                if(data.success) {
                    $("#modal-message-content").html(data.message_html);
                    // Change background to white (read)
                    row.css('background-color', '#fff');
                } else {
                    $("#modal-message-content").html('<p>Error loading message.</p>');
                }
            },
            error: function() {
                $("#modal-message-content").html('<p>Error loading message.</p>');
            },
            complete: function() {
                // Re-enable button and reset text
                btn.prop('disabled', false).text('Show');
            }
        });
    });

    $('#messages-table').DataTable();
});
</script>

<?php require_once('footer.php'); ?> 
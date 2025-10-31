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

<style>
.modern-page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.modern-page-header h1 {
    margin: 0;
    font-size: 2rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.modern-page-header .subtitle {
    margin-top: 0.5rem;
    opacity: 0.9;
    font-size: 1.1rem;
}

.modern-filter-bar {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid #e3e6f0;
}

.modern-table-container {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid #e3e6f0;
}

.modern-table-container table {
    margin-bottom: 0;
}

.modern-table-container thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
    border: none;
    font-weight: 600;
    color: #5a5c69;
    padding: 1rem 0.75rem;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}

.modern-table-container tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #e3e6f0;
}

.modern-table-container tbody tr:hover {
    background-color: #f8f9fc;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.message-unread {
    background-color: #fff3cd !important;
    border-left: 4px solid #ffc107;
}

.message-read {
    background-color: #ffffff;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.contact-name {
    font-weight: 600;
    color: #2c3e50;
    font-size: 1rem;
}

.contact-email {
    color: #3498db;
    font-size: 0.9rem;
}

.contact-phone {
    color: #27ae60;
    font-size: 0.9rem;
}

.message-date {
    font-size: 0.9rem;
    color: #7f8c8d;
    font-weight: 500;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.modern-btn {
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-show {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
}

.btn-show:hover {
    background: linear-gradient(135deg, #2980b9, #1f618d);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(52, 152, 219, 0.3);
    color: white;
    text-decoration: none;
}

.btn-delete {
    background: linear-gradient(135deg, #e74a3b, #c0392b);
    color: white;
}

.btn-delete:hover {
    background: linear-gradient(135deg, #c0392b, #a93226);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(231, 74, 59, 0.3);
    color: white;
    text-decoration: none;
}

.search-box {
    width: 100%;
    padding: 0.8rem 1rem;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-box:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.stats-card {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid #e3e6f0;
    text-align: center;
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
}

.stats-label {
    font-size: 0.9rem;
    color: #7f8c8d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 0.5rem;
}

.modern-modal .modal-content {
    border-radius: 10px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.modern-modal .modal-header {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    border-radius: 10px 10px 0 0;
    border-bottom: none;
}

.modern-modal .modal-title {
    font-weight: 600;
}

.modern-modal .modal-body {
    padding: 2rem;
    font-size: 1rem;
    line-height: 1.6;
}

.fade-in {
    animation: fadeIn 0.6s ease-out;
}

.slide-in {
    animation: slideIn 0.8s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-envelope"></i>
        Contact Messages
    </h1>
    <div class="subtitle">Manage customer inquiries and contact form submissions</div>
</div>

<?php
// Get message statistics
$stmt = $pdo->query("SELECT * FROM tbl_contact_messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_messages = count($messages);
$unread_messages = count(array_filter($messages, function($m) { return $m['is_read'] == 0; }));
$read_messages = $total_messages - $unread_messages;
?>

<div class="row" style="margin-bottom: 1.5rem;">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-number"><?php echo $total_messages; ?></div>
            <div class="stats-label">Total Messages</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-number" style="color: #f39c12;"><?php echo $unread_messages; ?></div>
            <div class="stats-label">Unread Messages</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-number" style="color: #27ae60;"><?php echo $read_messages; ?></div>
            <div class="stats-label">Read Messages</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-number">
                <?php echo $total_messages > 0 ? round(($read_messages / $total_messages) * 100) : 0; ?>%
            </div>
            <div class="stats-label">Response Rate</div>
        </div>
    </div>
</div>

<div class="modern-filter-bar fade-in">
    <div class="row">
        <div class="col-md-6">
            <input type="text" id="messageSearch" class="search-box" placeholder="🔍 Search messages by name, email, or phone...">
        </div>
        <div class="col-md-3">
            <select id="statusFilter" class="search-box">
                <option value="">All Messages</option>
                <option value="unread">Unread Messages</option>
                <option value="read">Read Messages</option>
            </select>
        </div>
        <div class="col-md-3">
            <div style="padding: 0.8rem 0; font-weight: 600; color: #5a5c69;">
                <i class="fa fa-info-circle"></i> Showing: <span id="visibleCount">0</span> messages
            </div>
        </div>
    </div>
</div>

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
            <div class="modern-table-container slide-in">
                <div class="table-responsive">
                    <table class="table" id="messages-table">
                        <thead>
                            <tr>
                                <th>Contact Information</th>
                                <th>Message Status</th>
                                <th>Date Received</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($messages as $msg):
                        ?>
                            <tr class="<?php echo $msg['is_read'] ? 'message-read' : 'message-unread'; ?>" data-status="<?php echo $msg['is_read'] ? 'read' : 'unread'; ?>">
                                <td>
                                    <div class="contact-info">
                                        <div class="contact-name">
                                            <i class="fa fa-user"></i> <?php echo htmlspecialchars($msg['name']); ?>
                                        </div>
                                        <div class="contact-email">
                                            <i class="fa fa-envelope"></i> <?php echo htmlspecialchars($msg['email']); ?>
                                        </div>
                                        <div class="contact-phone">
                                            <i class="fa fa-phone"></i> <?php echo htmlspecialchars($msg['phone']); ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if($msg['is_read']): ?>
                                        <span class="badge" style="background: #27ae60; color: white; padding: 0.4rem 0.8rem; border-radius: 15px;">
                                            <i class="fa fa-check-circle"></i> Read
                                        </span>
                                    <?php else: ?>
                                        <span class="badge" style="background: #f39c12; color: white; padding: 0.4rem 0.8rem; border-radius: 15px;">
                                            <i class="fa fa-exclamation-circle"></i> Unread
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="message-date">
                                        <i class="fa fa-calendar"></i>
                                        <?php echo date('M d, Y', strtotime($msg['created_at'])); ?>
                                        <br>
                                        <small><?php echo date('h:i A', strtotime($msg['created_at'])); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" class="modern-btn btn-show show-message-btn" data-id="<?php echo $msg['id']; ?>">
                                            <i class="fa fa-eye"></i> View Message
                                        </button>
                                        <a href="?delete=1&id=<?php echo $msg['id']; ?>" class="modern-btn btn-delete" onclick="return confirm('Are you sure you want to delete this message?');">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </div>
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
<div class="modal fade modern-modal" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="messageModalLabel" style="color: white;">
            <i class="fa fa-envelope-open"></i> Customer Message
        </h4>
      </div>
      <div class="modal-body" id="modal-message-content">
        <!-- Message will be loaded here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="fa fa-times"></i> Close
        </button>
      </div>
    </div>
  </div>
</div>

<script>
// Search and filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('messageSearch');
    const statusFilter = document.getElementById('statusFilter');
    const table = document.getElementById('messages-table');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    const visibleCountSpan = document.getElementById('visibleCount');
    
    // Update visible count initially
    updateVisibleCount();
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        let visibleCount = 0;
        
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const text = row.textContent.toLowerCase();
            const status = row.getAttribute('data-status');
            
            const matchesSearch = text.includes(searchTerm);
            const matchesStatus = statusValue === '' || status === statusValue;
            
            if (matchesSearch && matchesStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        }
        
        visibleCountSpan.textContent = visibleCount;
    }
    
    function updateVisibleCount() {
        visibleCountSpan.textContent = rows.length;
    }
    
    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    
    // Message modal functionality
    document.querySelectorAll('.show-message-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const id = this.getAttribute('data-id');
            const row = this.closest('tr');
            
            // Disable button and show loading text
            this.disabled = true;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
            
            // Show loading message in modal
            document.getElementById('modal-message-content').innerHTML = '<div style="text-align: center; padding: 2rem;"><i class="fa fa-spinner fa-spin fa-2x"></i><br><br>Loading message...</div>';
            $('#messageModal').modal('show');
            
            // AJAX to get message and mark as read
            fetch('messages.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'get_message=1&id=' + id
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('modal-message-content').innerHTML = data.message_html;
                    // Update row styling to show as read
                    row.className = row.className.replace('message-unread', 'message-read');
                    row.setAttribute('data-status', 'read');
                    // Update status badge
                    const statusBadge = row.querySelector('.badge');
                    if(statusBadge) {
                        statusBadge.style.background = '#27ae60';
                        statusBadge.innerHTML = '<i class="fa fa-check-circle"></i> Read';
                    }
                } else {
                    document.getElementById('modal-message-content').innerHTML = '<p>Error loading message.</p>';
                }
            })
            .catch(error => {
                document.getElementById('modal-message-content').innerHTML = '<p>Error loading message.</p>';
            })
            .finally(() => {
                // Re-enable button and reset text
                this.disabled = false;
                this.innerHTML = '<i class="fa fa-eye"></i> View Message';
            });
        });
    });
});
</script>

<?php require_once('footer.php'); ?> 
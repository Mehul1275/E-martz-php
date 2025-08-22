<?php
session_start();
include("inc/config.php");
if(!isset($_SESSION['user'])) {
	header('location: login.php');
	exit;
}
?>
<?php require_once('header.php'); ?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Admin Users</h1>
    </div>
    <div class="content-header-right">
        <a href="user-add.php" class="btn btn-primary btn-sm">Add New Admin</a>
    </div>
</section>
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_user");
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_ASSOC);
$total_admins = count($users);
?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-body table-responsive">
                    <div style="margin-bottom: 10px; font-weight: bold;">Total Admins: <?php echo $total_admins; ?></div>
                    <table id="example1" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $user): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($user['photo'])): ?>
                                        <img src="../assets/uploads/<?php echo htmlspecialchars($user['photo']); ?>" alt="Photo" width="40" height="40" style="object-fit:cover; border-radius:50%;">
                                    <?php else: ?>
                                        <img src="../assets/uploads/user-1.png" alt="Photo" width="40" height="40" style="object-fit:cover; border-radius:50%;">
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                <td><?php echo htmlspecialchars($user['role']); ?></td>
                                <td><?php echo htmlspecialchars($user['status']); ?></td>
                                <td>
                                    <a href="user-edit.php?id=<?php echo $user['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                                    <a href="#" class="btn btn-danger btn-xs" data-href="user-delete.php?id=<?php echo $user['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this item?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<script>
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>

<?php require_once('footer.php'); ?> 
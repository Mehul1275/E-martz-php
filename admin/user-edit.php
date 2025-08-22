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
    <h1>Edit Admin User</h1>
</section>
<?php
if (!isset($_GET['id'])) {
    header('Location: users.php');
    exit;
}
$id = (int)$_GET['id'];
$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id = ?");
$statement->execute([$id]);
$user = $statement->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    header('Location: users.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $role = trim($_POST['role']);
    $status = isset($_POST['status']) ? 'Active' : 'Inactive';
    $password = $_POST['password'];

    $errors = [];
    if (empty($full_name) || empty($email) || empty($role)) {
        $errors[] = 'Name, Email, and Role are required fields.';
    }

    if (empty($errors)) {
        if ($password != '') {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $statement = $pdo->prepare("UPDATE tbl_user SET full_name=?, email=?, phone=?, password=?, role=?, status=? WHERE id=?");
            $statement->execute([$full_name, $email, $phone, $password_hash, $role, $status, $id]);
        } else {
            $statement = $pdo->prepare("UPDATE tbl_user SET full_name=?, email=?, phone=?, role=?, status=? WHERE id=?");
            $statement->execute([$full_name, $email, $phone, $role, $status, $id]);
        }
        header('Location: users.php?success=1');
        exit;
    }
}
?>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach($errors as $error) echo '<p>'.$error.'</p>'; ?>
                </div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>">
                </div>
                <div class="form-group">
                    <label>Role *</label>
                    <select name="role" class="form-control" required>
                        <option value="Admin" <?php if($user['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
                        <option value="Super Admin" <?php if($user['role'] == 'Super Admin') echo 'selected'; ?>>Super Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Password (leave blank to keep current)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <input type="checkbox" name="status" <?php if($user['status'] == 'Active') echo 'checked'; ?>> Active
                </div>
                <button type="submit" class="btn btn-success">Update Admin</button>
                <a href="users.php" class="btn btn-default">Cancel</a>
            </form>
        </div>
    </div>
</section>
<?php require_once('footer.php'); ?> 
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
    <h1>Add New Admin User</h1>
</section>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $role = trim($_POST['role']);
    $password = $_POST['password'];
    $status = isset($_POST['status']) ? 'Active' : 'Inactive';

    $errors = [];
    if (empty($full_name) || empty($email) || empty($role) || empty($password)) {
        $errors[] = 'Name, Email, Role, and Password are required fields.';
    }

    $path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
            $errors[] = 'You must upload a jpg, jpeg, gif, or png file for the photo.';
        }
    }

    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $final_name = '';

        if ($path != '') {
            // Get the next auto-increment ID for tbl_user to name the photo
            $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_user'");
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $ai_id = $result['Auto_increment'];
            
            $final_name = 'user-'.$ai_id.'.'.$ext;
            move_uploaded_file($path_tmp, '../assets/uploads/'.$final_name);
        }

        // Get the next available ID and insert
        try {
            // Get the maximum ID and add 1
            $statement = $pdo->prepare("SELECT MAX(id) as max_id FROM tbl_user");
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $next_id = ($result['max_id'] ?? 0) + 1;
            
            // Insert with explicit ID to avoid conflicts
            $statement = $pdo->prepare("INSERT INTO tbl_user (id, full_name, email, phone, password, photo, role, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $statement->execute([$next_id, $full_name, $email, $phone, $password_hash, $final_name, $role, $status]);
            
        } catch (Exception $e) {
            // If explicit ID fails, try without ID (let database handle it)
            $statement = $pdo->prepare("INSERT INTO tbl_user (full_name, email, phone, password, photo, role, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $statement->execute([$full_name, $email, $phone, $password_hash, $final_name, $role, $status]);
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
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                 <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                <div class="form-group">
                    <label>Photo</label>
                    <input type="file" name="photo">
                </div>
                 <div class="form-group">
                    <label>Role *</label>
                    <select name="role" class="form-control" required>
                        <option value="Admin">Admin</option>
                        <option value="Super Admin">Super Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <input type="checkbox" name="status" value="Active" checked> Active
                </div>
                <button type="submit" class="btn btn-success">Add Admin</button>
                <a href="users.php" class="btn btn-default">Cancel</a>
            </form>
        </div>
    </div>
</section>
<?php require_once('footer.php'); ?> 
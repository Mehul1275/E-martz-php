<?php
session_start();
include("inc/config.php");
if(!isset($_SESSION['user'])) {
	header('location: login.php');
	exit;
}
?>
<style>
.modern-page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.modern-page-header h1 {
    margin: 0;
    font-size: 2.5rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 15px;
}

.modern-page-header .subtitle {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 1.1rem;
}

.modern-form-container {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #e3e6f0;
    max-width: 700px;
    margin: 0 auto;
}

.user-info-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 1.5rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    border-left: 4px solid #667eea;
}

.user-info-section h3 {
    margin: 0 0 1rem 0;
    color: #2c3e50;
    font-size: 1.3rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.user-detail-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #495057;
    font-size: 0.95rem;
}

.modern-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.modern-form-group {
    margin-bottom: 1.5rem;
}

.modern-form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.95rem;
}

.modern-form-label .required {
    color: #e74c3c;
    margin-left: 3px;
}

.modern-form-input, .modern-form-select {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.modern-form-input:focus, .modern-form-select:focus {
    outline: none;
    border-color: #667eea;
    background-color: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.modern-checkbox-group {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    background: #f8f9fa;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.modern-checkbox-group:hover {
    background: white;
    border-color: #667eea;
}

.modern-checkbox {
    width: 18px;
    height: 18px;
    accent-color: #667eea;
}

.checkbox-label {
    font-weight: 500;
    color: #495057;
    cursor: pointer;
}

.modern-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.modern-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    color: white;
}

.modern-btn-secondary {
    background: #6c757d;
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    margin-left: 10px;
}

.modern-btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-1px);
    color: white;
}

.modern-alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    border: none;
    font-weight: 500;
}

.modern-alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f1b0b7 100%);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

.form-actions {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e3e6f0;
    text-align: center;
}

.role-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.role-admin {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.role-super-admin {
    background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
    color: white;
}

.status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-active {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.status-inactive {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    color: white;
}

@media (max-width: 768px) {
    .modern-page-header {
        padding: 1.5rem;
        text-align: center;
    }
    
    .modern-page-header h1 {
        font-size: 2rem;
        justify-content: center;
    }
    
    .modern-form-container {
        padding: 1.5rem;
        margin: 0 1rem;
    }
    
    .modern-form-row {
        grid-template-columns: 1fr;
    }
    
    .user-details {
        grid-template-columns: 1fr;
    }
}
</style>

<?php require_once('header.php'); ?>
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

<div class="modern-page-header" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-user-edit"></i>
        Edit Admin User
    </h1>
    <p class="subtitle">Update administrator account information and permissions</p>
    <div style="margin-top: 1rem;">
        <a href="users.php" class="modern-btn-secondary">
            <i class="fa fa-users"></i>
            View All Users
        </a>
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($errors)): ?>
            <div class="modern-alert modern-alert-danger">
                <i class="fa fa-exclamation-triangle"></i>
                <?php foreach($errors as $error) echo '<p style="margin: 0;">'.$error.'</p>'; ?>
            </div>
            <?php endif; ?>

            <div class="user-info-section">
                <h3>
                    <i class="fa fa-info-circle"></i>
                    Current User Information
                </h3>
                <div class="user-details">
                    <div class="user-detail-item">
                        <i class="fa fa-id-badge"></i>
                        <strong>User ID:</strong> #<?php echo htmlspecialchars($user['id']); ?>
                    </div>
                    <div class="user-detail-item">
                        <i class="fa fa-user-tag"></i>
                        <strong>Role:</strong> 
                        <span class="role-badge <?php echo $user['role'] == 'Super Admin' ? 'role-super-admin' : 'role-admin'; ?>">
                            <?php echo htmlspecialchars($user['role']); ?>
                        </span>
                    </div>
                    <div class="user-detail-item">
                        <i class="fa fa-toggle-on"></i>
                        <strong>Status:</strong> 
                        <span class="status-badge <?php echo $user['status'] == 'Active' ? 'status-active' : 'status-inactive'; ?>">
                            <?php echo htmlspecialchars($user['status']); ?>
                        </span>
                    </div>
                    <div class="user-detail-item">
                        <i class="fa fa-calendar"></i>
                        <strong>Last Updated:</strong> <?php echo date('M d, Y'); ?>
                    </div>
                </div>
            </div>

            <div class="modern-form-container">
                <form method="post">
                    <div class="modern-form-row">
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fa fa-user"></i>
                                Full Name
                                <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   name="full_name" 
                                   class="modern-form-input" 
                                   value="<?php echo htmlspecialchars($user['full_name']); ?>"
                                   placeholder="Enter full name"
                                   required>
                        </div>
                        
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fa fa-envelope"></i>
                                Email Address
                                <span class="required">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   class="modern-form-input" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>"
                                   placeholder="Enter email address"
                                   required>
                        </div>
                    </div>

                    <div class="modern-form-row">
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fa fa-phone"></i>
                                Phone Number
                            </label>
                            <input type="text" 
                                   name="phone" 
                                   class="modern-form-input" 
                                   value="<?php echo htmlspecialchars($user['phone']); ?>"
                                   placeholder="Enter phone number" maxlength="10" inputmode="numeric" pattern="\d{10}" oninput="this.value=this.value.replace(/\D/g,'').slice(0,10)">
                        </div>
                        
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fa fa-user-shield"></i>
                                User Role
                                <span class="required">*</span>
                            </label>
                            <select name="role" class="modern-form-select" required>
                                <option value="">Select Role</option>
                                <option value="Admin" <?php if($user['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
                                <option value="Super Admin" <?php if($user['role'] == 'Super Admin') echo 'selected'; ?>>Super Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="modern-form-group">
                        <label class="modern-form-label">
                            <i class="fa fa-lock"></i>
                            New Password
                            <small style="font-weight: normal; color: #6c757d;">(leave blank to keep current password)</small>
                        </label>
                        <input type="password" 
                               name="password" 
                               class="modern-form-input" 
                               placeholder="Enter new password or leave blank">
                    </div>

                    <div class="modern-form-group">
                        <label class="modern-form-label">
                            <i class="fa fa-toggle-on"></i>
                            Account Status
                        </label>
                        <div class="modern-checkbox-group">
                            <input type="checkbox" 
                                   name="status" 
                                   class="modern-checkbox" 
                                   id="status"
                                   <?php if($user['status'] == 'Active') echo 'checked'; ?>>
                            <label for="status" class="checkbox-label">
                                Account is Active
                            </label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="modern-btn">
                            <i class="fa fa-save"></i>
                            Update User
                        </button>
                        <a href="users.php" class="modern-btn-secondary">
                            <i class="fa fa-times"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require_once('footer.php'); ?>
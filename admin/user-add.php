<?php
session_start();
include("inc/config.php");
if(!isset($_SESSION['user'])) {
	header('location: login.php');
	exit;
}

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
<?php require_once('header.php'); ?>
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

.modern-file-upload {
    position: relative;
    display: inline-block;
    width: 100%;
}

.modern-file-input {
    width: 100%;
    padding: 40px 15px;
    border: 2px dashed #e3e6f0;
    border-radius: 8px;
    background-color: #f8f9fa;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modern-file-input:hover {
    border-color: #667eea;
    background-color: rgba(102, 126, 234, 0.05);
}

.modern-checkbox-group {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    background-color: #f8f9fa;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.modern-checkbox-group:hover {
    border-color: #667eea;
    background-color: rgba(102, 126, 234, 0.05);
}

.modern-checkbox {
    width: 18px;
    height: 18px;
    accent-color: #667eea;
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
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
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
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="modern-page-header" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-user-plus"></i>
        Add New Admin User
    </h1>
    <p class="subtitle">Create a new admin user account with appropriate permissions</p>
    <div style="margin-top: 1rem;">
        <a href="users.php" class="modern-btn-secondary">
            <i class="fa fa-users"></i>
            View All Users
        </a>
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-6">
            <?php if (!empty($errors)): ?>
                <div class="modern-alert modern-alert-danger">
                    <?php foreach($errors as $error) echo '<p>'.$error.'</p>'; ?>
                </div>
            <?php endif; ?>
            <div class="modern-form-container">
                <form method="post" enctype="multipart/form-data">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Full Name <span class="required">*</span></label>
                        <input type="text" name="full_name" class="modern-form-input" required>
                    </div>
                    <div class="modern-form-group">
                        <label class="modern-form-label">Email <span class="required">*</span></label>
                        <input type="email" name="email" class="modern-form-input" required>
                    </div>
                    <div class="modern-form-group">
                        <label class="modern-form-label">Phone</label>
                        <input type="text" name="phone" class="modern-form-input" maxlength="10" inputmode="numeric" pattern="\d{10}" oninput="this.value=this.value.replace(/\D/g,'').slice(0,10)">
                    </div>
                    <div class="modern-form-group">
                        <label class="modern-form-label">Photo</label>
                        <div class="modern-file-upload">
                            <input type="file" name="photo" class="modern-file-input">
                        </div>
                    </div>
                    <div class="modern-form-group">
                        <label class="modern-form-label">Role <span class="required">*</span></label>
                        <select name="role" class="modern-form-select" required>
                            <option value="Admin">Admin</option>
                            <option value="Super Admin">Super Admin</option>
                        </select>
                    </div>
                    <div class="modern-form-group">
                        <label class="modern-form-label">Password <span class="required">*</span></label>
                        <input type="password" name="password" class="modern-form-input" required>
                    </div>
                    <div class="modern-form-group">
                        <label class="modern-form-label">Status</label>
                        <div class="modern-checkbox-group">
                            <input type="checkbox" name="status" value="Active" checked class="modern-checkbox">
                            <span>Active</span>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="modern-btn">
                            <i class="fa fa-plus"></i>
                            Add Admin
                        </button>
                        <a href="users.php" class="modern-btn-secondary">
                            <i class="fa fa-users"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?> 
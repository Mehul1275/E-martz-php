<?php
declare(strict_types=1);

/**
 * Get file extension from uploaded file
 * 
 * @param PDO $pdo Database connection
 * @param string $fname Form field name
 * @return string File extension
 */
function get_ext(PDO $pdo, string $fname): string
{
    if (!isset($_FILES[$fname]) || $_FILES[$fname]['error'] !== UPLOAD_ERR_OK) {
        return '';
    }
    
    $up_filename = $_FILES[$fname]["name"];
    $file_basename = substr($up_filename, 0, strripos($up_filename, '.')); // strip extension
    $file_ext = substr($up_filename, strripos($up_filename, '.')); // strip name
    return $file_ext;
}

/**
 * Check if file extension is allowed
 * 
 * @param PDO $pdo Database connection
 * @param string $allowed_ext Allowed extensions (pipe separated)
 * @param string $my_ext File extension to check
 * @return bool True if extension is allowed
 */
function ext_check(PDO $pdo, string $allowed_ext, string $my_ext): bool 
{
    $arr1 = explode("|", $allowed_ext);	
    $count_arr1 = count($arr1);	

    for($i = 0; $i < $count_arr1; $i++) {
        $arr1[$i] = '.' . $arr1[$i];
    }
	
    $stat = 0;
    for($i = 0; $i < $count_arr1; $i++) {
        if($my_ext === $arr1[$i]) {
            $stat = 1;
            break;
        }
    }

    return $stat === 1;
}

/**
 * Get next auto increment ID for a table
 * 
 * @param PDO $pdo Database connection
 * @param string $tbl_name Table name
 * @return int Next auto increment ID
 */
function get_ai_id(PDO $pdo, string $tbl_name): int 
{
    $statement = $pdo->prepare("SHOW TABLE STATUS LIKE ?");
    $statement->execute([$tbl_name]);
    $result = $statement->fetch();
    
    return (int)($result['Auto_increment'] ?? 1);
}

/**
 * Sanitize input data
 * 
 * @param string $data Input data to sanitize
 * @return string Sanitized data
 */
function sanitize_input(string $data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate email address
 * 
 * @param string $email Email to validate
 * @return bool True if email is valid
 */
function validate_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Generate secure random token
 * 
 * @param int $length Token length
 * @return string Random token
 */
function generate_token(int $length = 32): string
{
    return bin2hex(random_bytes($length));
}

/**
 * Hash password using modern PHP password_hash
 * 
 * @param string $password Plain text password
 * @return string Hashed password
 */
function hash_password(string $password): string
{
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Verify password against hash
 * 
 * @param string $password Plain text password
 * @param string $hash Stored hash
 * @return bool True if password matches
 */
function verify_password(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}
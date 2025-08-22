<?php
declare(strict_types=1);

/**
 * A simple CSRF class to protect forms against CSRF attacks. The class uses
 * PHP sessions for storage.
 * 
 * @author Raahul Seshadri
 * Updated for PHP 8.4 compatibility
 */
class CSRF_Protect
{
    /**
     * The namespace for the session variable and form inputs
     * @var string
     */
    private string $namespace;
    
    /**
     * Initializes the session variable name, starts the session if not already so,
     * and initializes the token
     * 
     * @param string $namespace
     */
    public function __construct(string $namespace = '_csrf')
    {
        $this->namespace = $namespace;
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->setToken();
    }
    
    /**
     * Return the token from persistent storage
     * 
     * @return string
     */
    public function getToken(): string
    {
        return $this->readTokenFromStorage();
    }
    
    /**
     * Verify if supplied token matches the stored token
     * 
     * @param string $userToken
     * @return bool
     */
    public function isTokenValid(string $userToken): bool
    {
        return hash_equals($userToken, $this->readTokenFromStorage());
    }
    
    /**
     * Echoes the HTML input field with the token, and namespace as the
     * name of the field
     */
    public function echoInputField(): void
    {
        $token = $this->getToken();
        echo "<input type=\"hidden\" name=\"{$this->namespace}\" value=\"" . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . "\" />";
    }
    
    /**
     * Verifies whether the post token was set, else dies with error
     */
    public function verifyRequest(): void
    {
        if (!isset($_POST[$this->namespace]) || !$this->isTokenValid($_POST[$this->namespace])) {
            http_response_code(403);
            die("CSRF validation failed.");
        }
    }
    
    /**
     * Generates a new token value and stores it in persistent storage, or else
     * does nothing if one already exists in persistent storage
     */
    private function setToken(): void
    {
        $storedToken = $this->readTokenFromStorage();
        
        if ($storedToken === '') {
            $token = bin2hex(random_bytes(32));
            $this->writeTokenToStorage($token);
        }
    }
    
    /**
     * Reads token from persistent storage
     * @return string
     */
    private function readTokenFromStorage(): string
    {
        return $_SESSION[$this->namespace] ?? '';
    }
    
    /**
     * Writes token to persistent storage
     */
    private function writeTokenToStorage(string $token): void
    {
        $_SESSION[$this->namespace] = $token;
    }
}

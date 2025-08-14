<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/db_config.php";

class User{
    protected $db;
    protected $baseUrl;
    public function __construct($pdo = null){
        global $conn;
        $this->db = $pdo instanceof PDO ? $pdo : (isset($conn) ? $conn : null);

        $this->baseUrl = defined("BASE_URL") ? BASE_URL : $this->guessBaseUrl();
    }
    function guessBaseUrl(){
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return $scheme . '://' . $host . '/ecommerce'; 
    }
}

?>
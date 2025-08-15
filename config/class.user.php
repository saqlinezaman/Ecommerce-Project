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
    // helper method
       public function redirect($url){
        header("Location: .$url");
        exit;
       }
       public function is_logged_in(){
        return !empty($_SESSION["user_id"]);
       }

       public function logout(){
        session_unset();
        session_destroy();
        return true;
       }
       public function get_user_by_id($id){
        $statement = $this->db->prepare("SELECT id, username, email, verified FROM users WHERE id = ? LIMIT 1");
        $statement->execute([$id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
       }

    // auth core
    public function register($username, $email, $password){
        $statement = $this->db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $statement->execute([$email]);
        if($statement->fetch()){
            throw new Exception("This email is already registered!");
        }
        // token with hexadecimal hashing token
        $token = bin2hex(random_bytes(16));
        // hash password
        $hash = password_hash($password, PASSWORD_DEFAULT);
        // insert query 
        $insert_query = $this->db->prepare("INSERT INTO users (username, email, password, token, verified) VALUES (?,?,?,?,0)");
        $insert_query->execute([$username, $email, $hash, $token]);

        // send mail
        $verifyLink = $this->baseUrl. "/auth/verify.php?token=".urlencode($token)."&email=".urlencode($email);
        $this->setMail($email, "Verify your email", "Click the link to verify:{$verifyLink} ");
        return true;
    } 

    public function login ($email, $password){
        $statement = $this->db->prepare("SELECT * FROM users where email = ? LIMIT 1");
        $statement->execute([$email]);

        $u = $statement->fetch(PDO::FETCH_ASSOC);
             if(!$u){
            throw new Exception("Invalid Credentials");
        }
        if(!password_verify($password, $u["password"])){
           throw new Exception("Invalid Credentials");
    }
    if((int)$u['verified'] !== 1){
         throw new Exception("Your email is not verified please verify your email");
    }
    $_SESSION['user_id'] = $u['id'] ;
    $_SESSION['user_email'] = $u['email'] ;
    $_SESSION['user_name'] = $u['username'] ;
    return true;
}

public function verify ($email, $token) {

    $statement = $this->db->prepare('SELECT id, token, verified FROM users WHERE email = ? LIMIT 1');
    $statement->execute([$email]);
    $u = $statement->fetch(PDO::FETCH_ASSOC);

    if(!$u){
         throw new Exception("Account not found");
    }
    if((int)$u['verified'] === 1){
         return true;
    }
    if(!hash_equals($u['token'] ?? '', $token ?? '')){
        throw new Exception('Invalid Verification token ');
    }
    $update = $this->db->prepare('UPDATE users SET verified = 1, token = null WHERE id = ?');
    $update->execute([$u['id']]);
    return true;
}
public function requestPasswordReset($email){

    $statement = $this->db->prepare('SELECT id, username FROM users WHERE email = ? LIMIT 1');
    $statement->execute([$email]);
    $u = $statement->fetch(PDO::FETCH_ASSOC);
    if(!$u) return true;
    $token = bin2hex(random_bytes(16));

}


}

?>
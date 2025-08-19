<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/db_config.php";

class User
{
    private $connection;
    private $baseUrl;

    public function __construct($pdo = null)
    {
         $database = new Database();
         $db = $database->db_connection(); 
         $this->connection = $db;
         
        $this->baseUrl = defined("BASE_URL") ? BASE_URL : $this->guessBaseUrl();
    }

    function guessBaseUrl()
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return $scheme . '://' . $host . '/ecommerce';
    }

    // helper method
    public function redirect($url)
    {
        header("Location: " . $url);
        exit;
    }

    public function is_logged_in()
    {
        return !empty($_SESSION["user_id"]);
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        return true;
    }

    public function get_user_by_id($id)
    {
        $statement = $this->connection->prepare("SELECT id, username, email, verified FROM users WHERE id = ? LIMIT 1");
        $statement->execute([$id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    // auth core register
    public function register($username, $email, $password)
    {
        $statement = $this->connection->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $statement->execute([$email]);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        if ($statement->fetch()) {
            throw new Exception("This email is already registered!");
        }

        $token = bin2hex(random_bytes(16));
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $insert_query = $this->connection->prepare("INSERT INTO users (username, email, password, token, verified) VALUES (?,?,?,?,0)");
        $insert_query->execute([$username, $email, $hash, $token]);

        $verifyLink = $this->baseUrl . "/auth/verify.php?token=" . urlencode($token) . "&email=" . urlencode($email);

        $msg = '

        <div style="font-family: Arial; font-size: 14px; line-height: 1.6; color: #333;">
            <h2 style="margin: 0 0 12px;">Verify your email</h2>
            <p>Hi ' . htmlspecialchars($username) . ',</p>
            <p>Please click the button bellow to verify your account:</p>
            <p style="margin: 16px 0;">
                <a href="' . htmlspecialchars($verifyLink) . '" target="_blank" style="background: #007bff; color: white; text-decoration: none; padding: 10px 18px; border-radius: 6px; display: inline-block;">
                   Verify my account
                </a>
            </p>
            <p>If the button does not work, copy and paste this link into your browser:</p>
            <p>
                <a href="' . htmlspecialchars($verifyLink) . '" target="_blank">' . htmlspecialchars($verifyLink) . '</a>
            </p>
            <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
            <p style="font-size: 12px; color: #777;">
                If you did create this, you can ignore this email.
            </p>
        </div>
        ';
        $this->sendMail($email, 'Verify your email', $msg);
        return true;
    }

    // login
    public function login($email, $password)
    {
        $statement = $this->connection->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $statement->execute([$email]);

        $u = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$u) {
            throw new Exception("Invalid Credentials");
        }
        if (!password_verify($password, $u["password"])) {
            throw new Exception("Invalid Credentials");
        }
        if ((int) $u['verified'] !== 1) {
            throw new Exception("Your email is not verified please verify your email");
        }

        $_SESSION['user_id'] = $u['id'];
        $_SESSION['user_email'] = $u['email'];
        $_SESSION['user_name'] = $u['username'];
       
        header('Location:'.$this->baseUrl.'/');
        exit;
    }

    // verify
    public function verify($email, $token)
    {
        $statement = $this->connection->prepare('SELECT id, token, verified FROM users WHERE email = ? LIMIT 1');
        $statement->execute([$email]);
        $u = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$u) {
            throw new Exception("Account not found");
        }
        if ((int) $u['verified'] === 1) {
            return true;
        }
        if (!hash_equals($u['token'] ?? '', $token ?? '')) {
            throw new Exception('Invalid Verification token');
        }

        $update = $this->connection->prepare('UPDATE users SET verified = 1, token = null WHERE id = ?');
        $update->execute([$u['id']]);
        return true;
    }

    // request reset
    public function requestPasswordReset($email)
    {
        $statement = $this->connection->prepare('SELECT id, username FROM users WHERE email = ? LIMIT 1');
        $statement->execute([$email]);
        $u = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$u) return true;

        $token = bin2hex(random_bytes(16));
        $expire = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

        $up = $this->connection->prepare('UPDATE users SET reset_token = ?, reset_expires = ? WHERE id = ?');
        $up->execute([$token, $expire, $u['id']]);

        $reset_link = $this->baseUrl . "/auth/reset.php?token=" . urlencode($token) . "&email=" . urlencode($email);

        $message = '
        <div style="font-family: Arial; font-size: 14px; line-height: 1.6; color: #333;">
            <h2 style="margin: 0 0 12px;">Password Reset</h2>
            <p>Hi ' . htmlspecialchars($u['username']) . ',</p>
            <p>Click the button below to set a new password:</p>
            <p style="margin: 16px 0;">
                <a href="' . htmlspecialchars($reset_link) . '" target="_blank" style="background: #007bff; color: white; text-decoration: none; padding: 10px 18px; border-radius: 6px; display: inline-block;">
                    Reset My Password
                </a>
            </p>
            <p>If the button does not work, copy and paste this link into your browser:</p>
            <p>
                <a href="' . htmlspecialchars($reset_link) . '" target="_blank">' . htmlspecialchars($reset_link) . '</a>
            </p>
            <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
            <p style="font-size: 12px; color: #777;">
                If you did not request a password reset, you can ignore this email.
            </p>
        </div>
        ';

        $this->sendMail($email, "Reset your password", $message);
        return true;
    }

    // reset password
    public function resetPassword($email, $token, $new_password)
    {
        $statement = $this->connection->prepare("SELECT id, reset_token, reset_expires FROM users WHERE email = ? LIMIT 1");
        $statement->execute([$email]);
        $u = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$u) throw new Exception("Account not found");

        if (empty($u['reset_token']) || !hash_equals($u['reset_token'], $token ?? '')) {
            throw new Exception("Invalid or expired token");
        }

        if (!empty($u['reset_expires'])) {
            $now = new DateTime();
            $exp = new DateTime($u['reset_expires']);
            if ($now > $exp) {
                throw new Exception("Reset token expired, try again");
            }
        }

        $hash = password_hash($new_password, PASSWORD_DEFAULT);

        $update = $this->connection->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
        $update->execute([$hash, $u['id']]);

        return true;
    }

    //  sendMail function
    private function sendMail($email, $subject, $message)
    {
        require_once __DIR__ .'/mailer/PHPMailer.php';
        require_once __DIR__ .'/mailer/SMTP.php'; 

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        //$mail->SMTPDebug = 3;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'szmoaj100@gmail.com'; 
        $mail->Password = 'pejgwhvsrltwfdfe';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('szmoaj100@gmail.com','Marhaba e-commerce');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message);
       
        if( !$mail->send()){
            $_SESSION['mailError'] = $mail->ErrorInfo ?? 'mail send error';
            return false;
        }
        return true;
    }
}
?>

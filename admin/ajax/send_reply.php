<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();

header("Content-Type: application/json; charset=utf-8");
ini_set("display_errors", "0");
error_reporting(E_ERROR | E_PARSE);

ob_start();
if (empty($_SESSION["admin_logged_in"])) {
    echo json_encode(['ok' => false, 'err' => 'Unauthorized']);
    exit;
} else {
    require_once __DIR__ . '/../../config/db_config.php';
    require_once __DIR__ . '/../../config/class.user.php';

    try {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception('Invalid Method');
        }

        $id = (int) ($_POST['id'] ?? 0);
        $text = trim($_POST['reply'] ?? '');

        if ($id <= 0 || empty($text))
            throw new Exception('Missing Data');

        $database = new Database();
        $connect = $database->db_connection();
        $statement = $connect->prepare('SELECT * FROM contact_message WHERE id = ?');
        $statement->execute([$id]);

        $message = $statement->fetch(PDO::FETCH_ASSOC);

        if (empty($message))
            throw new Exception('Message not found');

        $email = $message['email'];
        $subject = 'Reply: ' . ($message['subject'] ?? 'Your inquiry');

        // Email message
        $html_message = '
        <div style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 1.6; color: #333;">
            <p>Hey, ' . htmlspecialchars($message['name']) . '</p>
            <p>' . nl2br(htmlspecialchars($text)) . '</p>
            <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
            <p style="font-size: 12px; color: #777;">This is reply to your message submitted on '. htmlspecialchars($message['created_at']) .' </p>
        </div>';

        // Reflection ব্যবহার করে private মেথড অ্যাক্সেস করুন
        $user = new User();
        $reflection = new ReflectionClass($user);
        $method = $reflection->getMethod('sendMail');
        $method->setAccessible(true);
        $ok = $method->invoke($user, $email, $subject, $html_message);
        
        // অথবা সরাসরি PHPMailer ব্যবহার করুন (যদি User ক্লাসে access না থাকে)
        // $ok = sendMailDirectly($email, $subject, $html_message);
        
        if (!$ok) {
            $err = $_SESSION['mailError'] ?? 'Email failed';
            throw new Exception($err);
        }

        $update = $connect->prepare('UPDATE contact_message SET is_replied = 1, replied_text = ?, replied_at = NOW() WHERE id = ? ');
        $update->execute([$text, $id]);
        ob_end_clean();
        echo json_encode(['ok' => true]);

    } catch (Throwable $e) {
       ob_end_clean();
       echo json_encode(['ok'=> false, 'err' => $e->getMessage()]);
    }
}

// Alternative mail function যদি Reflection কাজ না করে
function sendMailDirectly($to, $subject, $message) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: your-email@example.com' . "\r\n";
    
    return mail($to, $subject, $message, $headers);
}
?>
<?php 
require_once __DIR__ ."/config/db_config.php";

try {
    if($_SERVER["REQUEST_METHOD"] !== "POST") throw new Exception("Invalid");

    $name = trim($_POST["name"] ?? '');
    $email = trim($_POST['email'] ??'');
    $subject = trim($_POST['subject'] ??'');
    $message = trim($_POST['message'] ??'');

    if($name === '' || $email === '' || $subject === '' || $message === '') throw new Exception('Missing Data');

    $database = new Database();
    $connect = $database->db_connection();
    $statement = $connect->prepare("INSERT INTO contact_message (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $statement->execute([$name, $email, $subject, $message]);
    header("Location: contact.php?msg=ok");
    exit;

} catch (throwable $th) {
    error_log("Error in save_contact.php: " . $th->getMessage(), 3, __DIR__ . "/logs/error.log");
    header("Location: contact.php?msg=err");
    exit;
}
?>
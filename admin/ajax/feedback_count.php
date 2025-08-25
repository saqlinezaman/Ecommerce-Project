<?php
require_once __DIR__ . '/../../config/db_config.php';
if (session_status() == PHP_SESSION_NONE)
    session_start();

header("Content-Type: application/json; charset=utf-8");
header("Cache_Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

try {
    $database = new Database();
    $connect = $database->db_connection();

    $row = $connect->query("SELECT COUNT(*) AS c FROM contact_message WHERE is_replied = 0 ")->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['count'=>(int)$row['c'] ?? 0]);
} catch (Throwable $e) {
        echo json_encode(['count'=> 0]);

}



?>
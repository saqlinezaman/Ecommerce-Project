<?php

session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit;
}

include "includes/header.php";
include "includes/sidebar.php";
$page = $_GET['page'] ?? 'dashboard';
$page_path = "pages/" . basename($page) . ".php";
echo '<div class="content">';

if (file_exists($page_path)) {
    include $page_path;
} else {
    echo "<div style='margin-left:140px; margin-right:30px; padding:0px 10px; height:50px; display:flex; align-items:center;'  class='content alert alert-info'>404-Page Not Found!</div>";
}

echo '</div>';

include "includes/footer.php";
?>
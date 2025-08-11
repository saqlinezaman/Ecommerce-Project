<?php
ob_start();

if(!isset($_SESSION)) session_start();
include __DIR__ . '/../DBConfig.php';
$admin_id = $_SESSION['admin_logged_in'] ?? null;
$admin_image = 'default.jpg';
$admin_name = 'admin';
if($admin_id) {
	$statement = $DB_connection->prepare('SELECT * FROM admins where id = ?');
	$statement->execute([$admin_id]);
	$admin = $statement->fetch(PDO::FETCH_ASSOC);
	if($admin){
		$admin_image = !empty($admin['image']) ? $admin['image'] :'default.jpg';
		$admin_name = $admin['username'];
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Admin Panel</title>
	<!-- Bootstrap 5 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">

	<style type="text/css">
		body {
			margin: 0;
			padding: 0;
		}

		.sidebar {
			width: 250px;
			height: 100vh;
			position: fixed;
			background-color: #153a4fff;
			color: white;
		}

		.sidebar a {
			color: black;
			display: block;
			margin: 0;
			text-decoration: none;
			background-color: #00000027;
			padding: 5px 10px;
		}

		.content {
			margin-left: 125px;
			margin-top: 20px;
			padding: 25px 2px;
		}

		.profile-dropdown {
			position: relative;
		}

		.profile-btn {
			background: none;
			border: none;
			color: white;
			cursor: pointer;
			padding: 8px 12px;
			border-radius: 50px;
			transition: background-color 0.3s ease;
		}

		.profile-btn:hover {
			background-color: rgba(255, 255, 255, 0.1);
		}

		.profile-dropdown-menu {
			position: absolute;
			top: 100%;
			right: 0;
			background: white;
			border: 1px solid #ddd;
			border-radius: 8px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
			min-width: 200px;
			display: none;
			z-index: 1001;
		}

		.profile-dropdown-menu.show {
			display: block;
		}

		.profile-dropdown-item {
			display: block;
			padding: 12px 16px;
			color: #333;
			text-decoration: none;
			border-bottom: 1px solid #f0f0f0;
			transition: background-color 0.3s ease;
		}

		.profile-dropdown-item:hover {
			background-color: #f8f9fa;
			color: #333;
		}

		.profile-dropdown-item:last-child {
			border-bottom: none;
		}

		.profile-dropdown-item i {
			margin-right: 8px;
			width: 16px;
		}

		.thumbnail-image {
			width: 60px;
			height: 60px;
			object-fit: cover;
		}

		.color-box {
			width: 20px;
			height: 20px;
			display: inline-block;
			margin-right: 5px;
			border-radius: 50%;
			border: 1px solid #000;
		}

		/* Dropdown fix for header */
		.dropdown-menu {
			z-index: 1050 !important;
			position: absolute !important;
		}

		.dropdown {
			position: relative;
		}

		/* Ensure header stays on top */
		header {
			z-index: 1000;
		}
	</style>
</head>

<body>
	<header style="height: 60px; background-color: #153a4fff; position: fixed; top: 0; left: 0; right: 0; z-index: 1000;">
		<div class="d-flex justify-content-between p-2 align-items-center px-4">
			<h5 class="pt-3" style="color: white;">Ecommerce Admin Panel</h5>
			<div class="dropdown">
				<button class="btn btn-light  dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
					<!-- profile image -->
					<img src="uploads/admins/<?= htmlspecialchars($admin_image) ?>" alt="No photo found" class="rounded-circle" width="30" height="30">
					 <?=htmlspecialchars($admin_name); ?>
					 </button>
				<ul class="dropdown-menu px-2">
					<li><a class="dropdown-item mb-1 bg-primary text-white" href="?page=profile">Profile</a></li>
					<li><a class="dropdown-item mb-1" href="#">Something else here</a></li>
					<li><a href="logout.php" class="dropdown-item btn  bg-danger text-white rounded"><i class="fa-solid fa-arrow-right-from-bracket"></i>Logout</a></li>
				</ul>
			</div>
		</div>
	</header>

	<!-- Make sure Bootstrap JS is loaded properly -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

	<!-- If you're using jQuery, make sure it's loaded before Bootstrap -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

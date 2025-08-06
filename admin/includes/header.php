<!DOCTYPE html>
<html>

<head>
	<title>Admin Panel</title>
	<!-- Bootstrap 5 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Bootstrap 5 JS Bundle (with Popper) -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

	<!-- jQuery (optional, if you're using it elsewhere) -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

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
			margin-left: 120px;
			margin-top: 20px;
			padding: 30px 2px;
		}
	</style>
</head>

<body>
	<header
		style="height: 60px; background-color: #153a4fff; position: fixed; top: 0; left: 0; right: 0; z-index: 1000;">
		<div class="d-flex justify-content-between p-2  align-items-center ">
			<h5 class="pl-3 pt-3" style="color: white;">Ecommerce Admin Panel</h5>
			<a href="logout.php" class="btn btn-danger">Logout</a>
		</div>
	</header>
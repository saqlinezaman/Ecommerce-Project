<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
	<!-- bootstrap -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css" integrity="sha512-rt/SrQ4UNIaGfDyEXZtNcyWvQeOq0QLygHluFQcSjaGB04IxWhal71tKuzP6K8eYXYB6vJV4pHkXcmFGGQ1/0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!-- Bootstrap JS Bundle (includes Popper) -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<!--  font-awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<style type="text/css">
		body
		{
			margin:0;
			padding: 0;
		}

		.sidebar
		{
			width: 250px;
			height: 100vh;
			position: fixed;
			background-color: #153a4fff;
			color: white;
		}

		.sidebar a
		{
			color: black;
			display: block;
			margin:  0;
			text-decoration: none;
			background-color: #00000027 ;
			padding: 5px 10px ;
		}

		.content
		{
			margin-left: 120px ;
			margin-top: 20px;
			padding: 30px 2px;
		}

	</style>
</head>
<body>
	<header style="height: 60px; background-color: #153a4fff; position: fixed; top: 0; left: 0; right: 0; z-index: 1000;">
    <div class="d-flex justify-content-between pt-1 pr-4 align-items-center ">
		 <h5 class="pl-3 pt-3" style="color: white;">Ecommerce Admin Panel</h5>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</header>

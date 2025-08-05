<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css" integrity="sha512-rt/SrQ4UNIaGfDyEXZtNcyWvQeOq0QLygHluFQcSjaGB04IxWhal71tKuzP6K8eYXYB6vJV4pHkXcmFGGQ1/0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
			margin-left: 260px;
			padding: 80px 20px 20px;
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

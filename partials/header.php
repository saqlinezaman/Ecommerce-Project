<?php
if(session_status() === PHP_SESSION_NONE) session_start();
$BASE = define("BASE_URL") ? BASE_URL : ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== "off" ? "https" : 'http') ."://".($_SERVER['HTTP_HOST '] ?? "localhost").ecommerce);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Marhaba eCommerce</title>
</head>
<body>
  <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">Marhaba</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Menu -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">About us</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
      </ul>
      
      <!-- Search -->
      <form class="d-flex me-3">
        <input class="form-control me-2" type="search" placeholder="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      
      <!-- Register & Login -->
      <div>
        <button class="btn btn-dark btn-sm me-1">Register</button>
        <button class="btn btn-dark btn-sm">Login</button>
      </div>
    </div>
  </div>
</nav>
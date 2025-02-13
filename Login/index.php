<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Dashboard</title>

	<link rel="stylesheet" href="../CSS/index.css">
</head>
<body>
<a href="account.php">
  <img class="logo" src="../Logo/landing.png" alt="Logo">
</a>
    <div class="container">
        <h2>Welcome Back!</h2>
		<div class="search-container">
			<i class="fa-solid fa-magnifying-glass"></i>
			<input type="text" class="search-bar" placeholder="Search here....">
		</div>
        
        <div class="buttons">
            <button class="btn btn-primary">+ New Folder</button>
            <button class="btn btn-secondary">&#x1F4C4; Create Post</button>
        </div>
		
        
		<div class="nice-container">
		<div class="header">
			<div class="column" class="name-text">Name</div>
			<div class="column">Date Created</div>
			<div class="column">Action</div>
		</div>
		<div class="row">
			<div class="column">&#128193; Memes All Day</div>
			<div class="column">dd/mm/yy</div>
			<div class="column">...</div>
		</div>
		<div class="row">
			<div class="column">&#128451; Memes All Day</div>
			<div class="column">dd/mm/yy</div>
			<div class="column">...</div>
		</div>
		</div>
        
        <button class="btn btn-primary">show all</button>
        
        <h3>File Selection</h3>
        <div class="grid">
            <div class="file-card">📄 Cat Videos <br> dd/mm/yy</div>
            <div class="file-card">📄 Cat Videos <br> dd/mm/yy</div>
            <div class="file-card">📄 Cat Videos <br> dd/mm/yy</div>
			<div class="file-card">📄 Cat Videos <br> dd/mm/yy</div>
            <div class="file-card">📄 Cat Videos <br> dd/mm/yy</div>
            <div class="file-card">📄 Cat Videos <br> dd/mm/yy</div>
        </div>
    </div>
</body>
</html>

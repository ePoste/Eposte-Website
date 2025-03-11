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

<div>
    <div class="welcome-container">

        <div class="welcome-content">
            <h2 class="greetings">Welcome Back!</h2>
            <div class="logo-container">
                <a href="account.php">
                    <img class="logo" src="../Logo/setting.png" alt="Logo">
                </a>
            </div>
        </div>

        <div class="search-container">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="search-bar" placeholder="Search here....">
        </div>

        <div class="buttons">
            <button class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> New Folder</button>
            <button class="btn btn-secondary"><i class="fa-solid fa-download"></i> Create Post</button>
        </div>
            
        
    </div>
</div>

    <div class="list-container">
        <div class="header">
        <div class="column"></div>
            <div class="column" class="name-text">Name</div>
            <div class="column">Date Created</div>
            <div class="column">Action</div>
        </div>
        <div class="row">
            <div class="column"><i class="fa-solid fa-folder"></i></div>
            <div class="column">Memes All Day</div>
            <div class="column">dd/mm/yy</div>
            <div class="column"><i class="fa-solid fa-ellipsis"></i></div>
        </div>
        <div class="row">
            <div class="column"><i class="fa-solid fa-folder"></i></div>
            <div class="column">Memes All Day</div>
            <div class="column">dd/mm/yy</div>
            <div class="column"><i class="fa-solid fa-ellipsis"></i></div>
        </div>
            
    </div>
    <button class="show-all">show all</button>

    <div class="file-container">
      <p class="column">File selection</p>
        <div class="file-selection-flex">
            <div class="file-card">
                <div>Cat Videos</div>
                <div><i class="fa-regular fa-file"></i></div>
                <div>dd/mm/yy</div>
            </div>
            <div class="file-card">
                <div>Cat Videos</div>
                <div><i class="fa-regular fa-file"></i></div>
                <div>dd/mm/yy</div>
            </div>
            <div class="file-card">
                <div>Cat Videos</div>
                <div><i class="fa-regular fa-file"></i></div>
                <div>dd/mm/yy</div>
            </div>
            <div class="file-card">
                <div>Cat Videos</div>
                <div><i class="fa-regular fa-file"></i></div>
                <div>dd/mm/yy</div>
            </div>
            <div class="file-card">
                <div>Cat Videos</div>
                <div><i class="fa-regular fa-file"></i></div>
                <div>dd/mm/yy</div>
            </div>
            <div class="file-card">
                <div>Cat Videos</div>
                <div><i class="fa-regular fa-file"></i></div>
                <div>dd/mm/yy</div>
            </div>
            <div class="file-card">
                <div>Cat Videos</div>
                <div><i class="fa-regular fa-file"></i></div>
                <div>dd/mm/yy</div>
            </div>
            

        </div>
        <button class="show-all show-all-last">show all</button>
    </div>

</div>

</body>
</html>

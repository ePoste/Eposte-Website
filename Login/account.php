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
    <title>Account Settings</title>
    <link rel="stylesheet" href="../CSS/index.css">
</head>
<body>
<a href="account.php">
  <img class="logo" src="../Logo/landing.png" alt="Logo">
</a>

    
        <a href="index.php" class="menu-button">&#8592; Main Menu</a>
    

    <div class="settings">
        <h2>Account Settings</h2>
        
        <label for="email">Email</label>
        <input type="email" id="email" value="abc@xyc.com" readonly>
        
        <label for="current-password">Current Password</label>
        <input type="password" id="current-password">
        
        <label for="new-password">New Password</label>
        <input type="password" id="new-password">
        
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password">
        
        <button type="submit">Change Password</button>
    </div>

    <a href="logout.php" class="logout">Log out</a>

    <div class="delete">
        <button>Delete Account</button>
    </div>
</body>
</html>
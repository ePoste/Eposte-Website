<?php 
session_start();

include("connection.php");

$errorMessage = ""; // Variable to store error message

$folderId = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];

    $query = "SELECT * FROM sharedfolders WHERE folderId = $folderId AND SharedTo = '$email'";
    $resultShared = mysqli_query($con,$query);
    $query = "SELECT * FROM users WHERE email = '$email'";
    $resultEmail = mysqli_query($con,$query);
    if($resultShared->num_rows > 0){
        $errorMessage = "Already Shared";
    }
    else if($resultEmail->num_rows < 1){
        $errorMessage = "User Does Not Exist";
    }
    else if($email == $_SESSION['email']){
        $errorMessage = "Cannot Share To Yourself";
    }
    else{
    $query = "INSERT INTO Sharedfolders (folderId,sharedTo) VALUES ($folderId,'$email')";
    mysqli_query($con,$query);
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="..\CSS\shareFolder.css">

</head>

<body>
    <div class="logo-container">
      <a href="account.php"><img class="logo" src="../Logo/setting.png" alt="Logo"></a>
    </div>
    <div>
    <button class="go-back-button" onclick="window.location.href='index.php';">
    <i class="fa-solid fa-arrow-left"></i> Main Menu
    </div>
    <div>
    <p><?php echo $errorMessage;?></p>
    </div>
<form method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
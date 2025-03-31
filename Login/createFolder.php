<?php 
session_start();

include("connection.php");

$errorMessage = ""; // Variable to store error message

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name = $_POST['name'];
    $description = $_POST['description'];
    $ownerEmail = $_SESSION['email'];
    $created = date('Y-m-d H:i:s');
    $query = "SELECT * FROM folders WHERE ownerEmail = '$ownerEmail'";
    $result = mysqli_query($con,$query);

    while($row = $result->fetch_assoc()){
        if($name == $row['folderName']){
            $errorMessage = "No duplicate names";
        }
    }
    if(empty($errorMessage)){
    $query = "INSERT INTO folders (ownerEmail,folderName, created, description) VALUES ('$ownerEmail','$name','$created', '$description')";
    mysqli_query($con, $query);
    header("Location: index.php");
}
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../CSS/createFolder.css">
</head>
<body>
    <div class="logo-container">
                <a href="account.php">
                    <img class="logo" src="../Logo/setting.png" alt="Logo">
                </a>
    </div>
    <div id="folder-creation-container">
        <form method="post" id="folder-form">
            <label for="name">Folder Name</label>
            <input id="name" type="text" name="name">
            <label for="description">Folder Description</label>
            <input id="description" type="text" name="description">
            <input id="submit" type="submit">
        </form>
        <?php if (!empty($errorMessage)): ?>
                <p class="error-message" style="color: red; font-weight: bold; margin-top: 10px; text-align: center;"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
    </div>
</body>
</html>

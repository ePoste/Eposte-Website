<?php 
session_start();

include("connection.php");

$errorMessage = ""; // Variable to store error message

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name = $_POST['name'];
    $description = $_POST['description'];
    $ownerEmail = $_SESSION['email'];
    $folderId = $_POST['folder'];
    $created = date('Y-m-d H:i:s');
    $query = "SELECT * FROM folders WHERE ownerEmail = '$ownerEmail'";
    $result = mysqli_query($con,$query);

    if(empty($errorMessage)){
    $query = "INSERT INTO posts (ownerEmail,folderId,postName,postDescription, created) VALUES ('$ownerEmail','$folderId','$name', '$description','$created')";
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
    <link rel="stylesheet" href="../CSS/folderCreation.css">
</head>
<body>
    <div id="folder-creation-container">
        <p>THIS PAGE WILL BE FINISHED IN FINAL PROTOTYPE AS OF NOW IT IS FOR TESTING</p>
        <form method="post" id="folder-form">
            <label for="name">Post Name</label>
            <input id="name" type="text" name="name">
            <label for="description">Post Description</label>
            <input id="description" type="text" name="description">
            <label for="folder">Folder Id SWAP FOR NAME OF FOLDER LATER</label>
            <input id="folder" type="number" name="folder">
            <input id="submit" type="submit">
        </form>
        <?php if (!empty($errorMessage)): ?>
                <p class="error-message" style="color: red; font-weight: bold; margin-top: 10px; text-align: center;"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
    </div>
</body>
</html>
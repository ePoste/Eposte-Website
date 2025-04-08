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
    <title>Account Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../CSS/createFolder.css">

</head>

<body>
    <div class="welcome-container">
        <div class="welcome-content">
            <div>
                <button id="go-back-button" onclick="location.href='index.php';"><i class="fa-solid fa-arrow-left"></i>  Main menu</button>
                <a href="index.php"></a>
                <h2 class="greetings">Create new Folder</h2>
            </div>    
            <div class="logo-container">
                <a href="account.php">
                    <img class="logo" src="../Logo/setting.png" alt="Logo">
                </a>
            </div>
        </div>
    </div>

    <div class="setting-container">

        <label for="email" class="setting-label"><h2>Create Folder</h2></label>

        <form method="POST" class="change-form" onsubmit="return validate();" > 
            <div class="change-group">
                <label for="name" class="change-label">Folder's name</label>
                <input id="name" type="text" name="name" placeholder="name here...">
            </div>
            <div class="change-group">
                <label for="description" class="change-label">Description</label>
                <input id="description" type="text" name="description" placeholder="description here...(250 characters max)" maxlength="250">
            </div>
            <div class="button-container">
                <button type="submit" class="button-save">Create</button>
            </div>
        </form>
    </div>
<script>
function validate() {
    const name = document.getElementById('name').value.trim();
    if (name === "") {
        alert("Folder name cannot be empty.");
        return false;
    }
    return true;
}
</script>
</body>
</html>
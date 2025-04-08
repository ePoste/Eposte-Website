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
        if(!empty($_POST["delete"])){
            $query="DELETE FROM posts WHERE folderId =" . $_GET['id'] . ";";
            mysqli_query($con,$query);
            $query="DELETE FROM folders WHERE folderId =" . $_GET['id'] . ";";
            mysqli_query($con,$query);
            header("Location: index.php");
        }
        if($name == $row['folderName']){
            $errorMessage = "No duplicate names";
        }
    }
    if(empty($errorMessage)){
    $query = "UPDATE folders SET ownerEmail = '$ownerEmail', folderName = '$name', description = '$description' WHERE folderId=" . $_GET['id'] . ";";
    mysqli_query($con,$query);
    header("Location: index.php");
}
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../CSS/login.css">
    <script src="scripts/signup-validation.js" defer></script>
</head>
<body>
    <div id="edit-folder-container">
        <form method="post" id="folder-form">
            <label for="name">New Folder Name</label>
            <input id="name" type="text" name="name" value="<?php $name ?>">
            <label for="description">New Folder Description</label>
            <input id="description" type="text" name="description" value="<?php $description ?>">
            <label for="delete">Delete Folder</label>
            <input id="delete" type="checkbox" name="delete">
            <input id="submit" type="submit">
        </form>
        <form method="POST" action="deleteFolder.php"
      onsubmit="return confirm('⚠️ Deleting this folder will also delete all posts inside it. This cannot be undone. Are you sure?');">
  <input type="hidden" name="folderId" value="<?php echo $folder['folderId']; ?>">
  <button type="submit" class="delete-btn">Delete Folder</button>
</form>

        <?php if (!empty($errorMessage)): ?>
                <p class="error-message" style="color: red; font-weight: bold; margin-top: 10px; text-align: center;"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
    </div>
</body>
</html>
<?php 
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
$welcome = "All Folders";

$email = $_SESSION["email"];
$query = "SELECT * FROM folders WHERE ownerEmail = '$email' ORDER BY created DESC";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Folders</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="../CSS/index.css">
</head>
<body>

<div>
  
  <div class="welcome-container">
    <div class="welcome-content">
      <h2 class="greetings"><?php echo $welcome ?></h2>
      <div class="logo-container">
        <a href="account.php">
          <img class="logo" src="../Logo/setting.png" alt="Logo">
        </a>
      </div>
    </div>

    <button class="go-back-button" onclick="window.location.href='index.php';" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Main menu</button>

    <div class="search-container">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" class="search-bar" placeholder="Search here....">
    </div>

    <div class="buttons">
      <button onclick="window.location.href='createFolder2.php';" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> New Folder</button>
    </div>
  </div>
</div>

<div class="list-container">
  <?php 
  if (mysqli_num_rows($result) > 0) {
    echo '<div class="header">';
    echo '<div class="column"></div>';
    echo '<div class="column name-text">Name</div>';
    echo '<div class="column">Date Created</div>';
    echo '<div class="column">Action</div>';
    echo '</div>';

    while($folder = $result->fetch_assoc()) {
      echo '<div class="row">';
      echo '<div class="column"><a href="index.php?id=' . $folder['folderId'] . '"><i class="fa-solid fa-folder folder-icon"></i></a></div>';
      echo '<div class="column">' . $folder['folderName'] . '</div>';
      echo '<div class="column">' . $folder['created'] . '</div>';
      echo '<div class="column action-column">';
      echo '<div class="action-menu">';
      echo '<i class="fa-solid fa-ellipsis-h action-icon"></i>';
      echo '<div class="dropdown hidden">';
      echo '<button onclick="window.location.href=\'editFolder.php?id=' . $folder['folderId'] . '\';">Edit Folder</button>';
      echo '<button onclick="window.location.href=\'index.php?id=' . $folder['folderId'] . '\';">Open Folder</button>';
      echo '<form method="POST" action="deleteFolder.php" onsubmit="return confirm(\'Are you sure you want to delete this folder?\');">';
      echo '<input type="hidden" name="folderId" value="' . $folder['folderId'] . '">';
      echo '<button type="submit" class="delete-btn">Delete Folder</button>';
      echo '</form>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
    }
  }
  ?>
</div>

<script src="./scripts/menu.js" defer></script>
</body>
</html>

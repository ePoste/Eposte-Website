<?php 
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

$viewing_folder = !empty($_GET['id']);
$welcome = "Welcome Back!";

if ($viewing_folder) {
    $id = $_GET['id'];
    $query = "SELECT * FROM folders WHERE folderId = '$id'";
    $result = mysqli_query($con, $query);
    if ($row = $result->fetch_assoc()) {
        $welcome = $row['folderName'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
  <link rel="stylesheet" href="../CSS/index.css" />
</head>
<body>

<div>
  <div class="welcome-container">
    <div class="welcome-content">
      <h2 class="greetings"><?php echo $welcome ?></h2>
      <div class="logo-container">
        <a href="account.php">
          <img class="logo" src="../Logo/setting.png" alt="Logo" />
        </a>
      </div>
    </div>

    <?php if ($viewing_folder): ?>
      <button class="go-back-button" onclick="window.location.href='index.php';">
        <i class="fa-solid fa-arrow-left"></i> Main menu
      </button>
      <div class="date-created-container">
        <p id="date-created-text"><?php echo $row['created']; ?></p>
      </div>
      <div class="description-container">
        <p id="description-text"><?php echo $row['description']; ?></p>
      </div>
    <?php endif; ?>

    <div class="search-container">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" class="search-bar" placeholder="Search here...." />
    </div>

    <div class="buttons">
      <button onclick="window.location.href='createFolder2.php';" class="btn btn-primary">
        <i class="fa-solid fa-circle-plus"></i> New Folder
      </button>
      <button onclick="window.location.href='createPost.php';" class="btn btn-secondary">
        <i class="fa-solid fa-download"></i> Create Post
      </button>
    </div>
  </div>
</div>

<?php if (!$viewing_folder): ?>
<div class="list-container">
  <?php 
  $email = $_SESSION["email"];
  $query = "SELECT * FROM folders WHERE ownerEmail = '$email' ORDER BY folderId DESC LIMIT 3";
  $result = mysqli_query($con, $query);

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
      echo '<button onclick="window.location.href=\'editFolder2.php?id=' . $folder['folderId'] . '\';">Edit Folder</button>';
      echo '<button onclick="window.location.href=\'index.php?id=' . $folder['folderId'] . '\';">Open Folder</button>';
      echo '<form method="POST" action="deleteFolder.php" onsubmit="return confirm(\'Are you sure you want to delete this folder?\');">';
      echo '<input type="hidden" name="folderId" value="' . $folder['folderId'] . '">';
      echo '<button type="submit" class="delete-btn">Delete Folder</button>';
      echo '</form>';
      echo '</div>'; // dropdown
      echo '</div>'; // action-menu
      echo '</div>'; // action-column
      echo '</div>'; // row
    }

    echo '<div class="folder-footer">';
    echo '<button class="show-all" onclick="window.location.href=\'showAllFolder.php\';">show all</button>';
    echo '</div>';
  }
  ?>
</div>
<?php endif; ?>

<div class="file-container">
  <?php
  $email = $_SESSION["email"];

  if ($viewing_folder) {
    // Show files in selected folder
    $query = "SELECT * FROM posts WHERE folderId = '$id' AND ownerEmail = '$email' ORDER BY created DESC";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
      echo '<p class="column">File selection</p>';
      echo '<div class="file-selection-flex">';
      while ($post = $result->fetch_assoc()) {
        echo '<a href="viewPost.php?id=' . $post['postId'] . '" class="file-card" style="text-decoration: none; color: inherit;">';
        echo '<div>' . $post["postName"] . '</div>';
        echo '<div><i class="fa-regular fa-file"></i></div>';
        echo '<div>' . $post["created"] . '</div>';
        echo '</a>';
      }
      echo '</div>';
      echo '<button class="show-all show-all-last">show all</button>';
    } else {
      echo '<p style="text-align:center; margin-top:20px;">No posts in this folder yet.</p>';
    }
  } else {
    // Show recent files from any folder
    $query = "SELECT * FROM posts WHERE ownerEmail = '$email' ORDER BY created DESC LIMIT 10";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
      echo '<p class="column">Recent Posts</p>';
      echo '<div class="file-selection-flex">';
      while ($post = $result->fetch_assoc()) {
        echo '<a href="viewPost.php?id=' . $post['postId'] . '" class="file-card" style="text-decoration: none; color: inherit;">';
        echo '<div>' . $post["postName"] . '</div>';
        echo '<div><i class="fa-regular fa-file"></i></div>';
        echo '<div>' . $post["created"] . '</div>';
        echo '</a>';
        
      }
      echo '</div>';
      echo '<button class="show-all show-all-last">show all</button>';
    } else {
      echo '<p style="text-align:center; margin-top:20px;">No posts found yet.</p>';
    }
  }
  ?>
</div>

<script src="./scripts/menu.js" defer></script>
</body>
</html>

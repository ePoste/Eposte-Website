<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

    if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * FROM folders WHERE folderId = '$id'";
    $result = mysqli_query($con, $query);
    $welcome = $result->fetch_assoc()['folderName'];
    }else{
        $welcome = "Welcome Back";
    }
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
            <h2 class="greetings"><?php echo $welcome ?></h2>
            <div class="logo-container">
                <a href="account.php">
                    <img class="logo" src="../Logo/setting.png" alt="Logo">
                </a>
            </div>
        </div>
        <?php 
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $query = "SELECT * FROM folders WHERE folderId = $id";
            $result = mysqli_query($con,$query);
            $row = $result->fetch_assoc();
            echo '<button onclick="window.location.href=\'index.php\';"> Go Back </button>';
            echo " <div class='date-created-container'>";
            echo "<p id = 'date-created-text'> ",$row['created'] ,"</p>";
            echo "</div>";
            echo " <div class='description-container'>";
            echo "<p id = 'description-text'> ",$row['description'] ,"</p>";
            echo "</div>";
        }
        ?>
        <div class="search-container">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="search-bar" placeholder="Search here....">
        </div>

        <div class="buttons">
            <button onclick="window.location.href='createFolder.php';" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> New Folder</button>
            <button onclick="window.location.href='createPost.php';" class="btn btn-secondary"><i class="fa-solid fa-download"></i> Create Post</button>
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
        <?php 
            $email = $_SESSION["email"];
            $query = "SELECT * FROM folders WHERE ownerEmail = '$email'";
            $result = mysqli_query($con, $query);
            while($folder = $result->fetch_assoc()){
            echo '<div class="row">';
            echo '<div class="column"><i class="fa-solid fa-folder"></i></div>';
            echo '<div class="column">' , $folder['folderName']  , '</div>';
            echo '<div class="column">' , $folder['created'] , '</div>';
            echo '<button onclick="window.location.href=\'editFolder.php?id=' . $folder['folderId'] . '\';" class="btn btn-secondary"><i class="fa-solid fa-download"></i> Edit Folder</button>';
            echo '<button onclick="window.location.href=\'index.php?id=' . $folder['folderId'] . '\';" class="btn btn-folder"><i class="fa-solid fa-download"></i> Open Folder</button>';
            echo '</div>';
            
            }
        ?>
            
    </div>
    <button class="show-all">show all</button>

    <div class="file-container">
      <p class="column">File selection</p>
        <div class="file-selection-flex">
            <?php
            if(!empty($_GET['id'])){
                $id = $_GET['id'];
                $query = "SELECT * FROM posts WHERE folderId = '$id'";
                $result = mysqli_query($con, $query);
                while($post = $result->fetch_assoc()){
                    echo'<div class="file-card">';
                    echo'<div>', $post["postName"] ,'</div>';
                    echo'<div><i class="fa-regular fa-file"></i></div>';
                    echo'<div>', $post["created"] ,'</div>';
                    echo'</div>';
                }
            }
            ?>

        </div>
        <button class="show-all show-all-last">show all</button>
    </div>

</div>

</body>
</html>

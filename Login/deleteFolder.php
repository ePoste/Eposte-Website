<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);
$email = $_SESSION["email"];

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["folderId"])) {
    $folderId = intval($_POST["folderId"]);

    // Check that the folder belongs to the logged-in user
    $check = mysqli_query($con, "SELECT * FROM folders WHERE folderId = $folderId AND ownerEmail = '$email'");
    if ($check && mysqli_num_rows($check) > 0) {

        // Delete all posts in the folder (posttags will be auto-deleted due to ON DELETE CASCADE)
        mysqli_query($con, "DELETE FROM posts WHERE folderId = $folderId");

        // Delete the folder
        mysqli_query($con, "DELETE FROM folders WHERE folderId = $folderId");

        // Redirect back to dashboard
        header("Location: index.php");
        exit();
    } else {
        echo "You do not have permission to delete this folder.";
    }
} else {
    echo "Invalid request.";
}
?>

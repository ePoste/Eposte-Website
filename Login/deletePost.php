<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);
$email = $_SESSION["email"];

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["postId"])) {
    $postId = intval($_POST["postId"]);

    // Confirm the user owns the post
    $check = mysqli_query($con, "SELECT folderId FROM posts WHERE postId = $postId AND ownerEmail = '$email'");
    if ($check && mysqli_num_rows($check) > 0) {
        $folderId = mysqli_fetch_assoc($check)['folderId'];

        // Delete tag relationships first
        mysqli_query($con, "DELETE FROM posttags WHERE postId = $postId");

        // Then delete the post
        mysqli_query($con, "DELETE FROM posts WHERE postId = $postId");

        header("Location: index.php?id=$folderId");
        exit();
    }
}
echo "Unauthorized or invalid request.";
?>

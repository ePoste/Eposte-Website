<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["folderId"])) {
    $folderId = intval($_POST["folderId"]); // basic sanitation

    // Optional: check if folder belongs to the logged-in user
    $email = $_SESSION["email"];
    $check = mysqli_query($con, "SELECT * FROM folders WHERE folderId = $folderId AND ownerEmail = '$email'");
    if (mysqli_num_rows($check) > 0) {
        // Delete posts first
        mysqli_query($con, "DELETE FROM posts WHERE folderId = $folderId");

        // Then delete the folder
        mysqli_query($con, "DELETE FROM folders WHERE folderId = $folderId");
    }

    header("Location: index.php");
    exit();
} else {
    header("Location: index.php"); // fallback
    exit();
}
?>

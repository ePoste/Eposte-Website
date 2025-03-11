<?php
session_start();

include("connection.php");
include("functions.php");

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['email']; // Get the logged-in user's email

// Check if the user confirmed account deletion
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'yes') {
        // SQL query to delete the user by email
        $query = "DELETE FROM users WHERE email = '$user_email' LIMIT 1";
        $result = mysqli_query($con, $query);

        if ($result) {
            // Log out the user by destroying the session
            session_destroy();
            header("Location: login.php?account_deleted=true");
            exit;
        } else {
            $errorMessage = "Something went wrong. Please try again.";
        }
    } else {
        $errorMessage = "Account deletion not confirmed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" href="../CSS/style.css"> <!-- Link your CSS here -->
</head>
<body>
    <!-- Background overlay for blur effect -->
    <div class="overlay"></div>

    <!-- The modal confirmation box -->
    <div class="confirmation-box">
        <h2>Are you sure you want to delete your account?</h2>
        <form method="POST">
            <p>Once you delete your account, all your data will be permanently lost.</p>
            <button type="submit" name="confirm_delete" value="yes" class="confirm-btn">Yes, delete my account</button>
            <button type="button" onclick="window.location.href='account.php'" class="cancel-btn">Cancel</button>
        </form>

        <!-- Display any error messages -->
        <?php if (!empty($errorMessage)): ?>
            <p class="error-message" style="color: red; text-align: center;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
    </div>

    <script>
        // Add a delay of 3 seconds before redirecting to the login page (after account deletion)
        setTimeout(function() {
            if (window.location.href.indexOf('account_deleted=true') > -1) {
                window.location.href = 'login.php'; // Redirect to login page after account deletion
            }
        }, 3000);
    </script>
</body>
</html>

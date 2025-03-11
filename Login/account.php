<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

$errorMessage = "";
$successMessage = "";

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['email']; // Get logged-in user's email

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['current_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $errorMessage = "All fields are required!";
        } elseif ($new_password !== $confirm_password) {
            $errorMessage = "New passwords do not match!";
        } else {
            // Check current password
            $query = "SELECT password FROM users WHERE email = '$user_email' LIMIT 1";
            $result = mysqli_query($con, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);

                if ($user_data['password'] === $current_password) {
                    // Update password
                    $update_query = "UPDATE users SET password = '$new_password' WHERE email = '$user_email'";
                    if (mysqli_query($con, $update_query)) {
                        $_SESSION['successMessage'] = "Password changed successfully!";
                        header("Location: account.php"); // Redirect to the same page to display the message
                        exit;
                    } else {
                        $errorMessage = "Something went wrong. Try again!";
                    }
                } else {
                    $errorMessage = "Current password is incorrect!";
                }
            } else {
                $errorMessage = "User not found!";
            }
        }
    } elseif (isset($_POST['delete_account'])) {
        // Delete account logic
        $query = "DELETE FROM users WHERE email = '$user_email'";
        if (mysqli_query($con, $query)) {
            session_destroy(); // Destroy the session
            $_SESSION['deleteMessage'] = "Account deleted successfully!";
            header("Location: login.php"); // Redirect to login page
            exit;
        } else {
            $errorMessage = "Something went wrong. Try again!";
        }
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
    <link rel="stylesheet" href="../CSS/setting.css">
    <script src="scripts/password-change-validation.js" defer></script>
</head>

<body>
    <div class="welcome-container">
        <div class="welcome-content">
            <div>
                <button id="go-back-button" onclick="location.href='index.php';"><i class="fa-solid fa-arrow-left"></i>  Main menu</button>
                <a href="index.php"></a>
                <h2 class="greetings">Account Settings</h2>
            </div>    
            <div class="logo-container">
                <a href="account.php">
                    <img class="logo" src="../Logo/setting.png" alt="Logo">
                </a>
            </div>
        </div>
    </div>

    <div class="setting-container">
        <div class="email-setting">
            <div class="form-group">
                <h2 class="setting-label">Email</h2>
                <input type="email" id="email" value="<?php echo htmlspecialchars($user_email); ?>" readonly>
            </div>
        </div>

        <label for="email" class="setting-label"><h2>Change Password</h2></label>

        <form method="POST" class="change-form" onsubmit="return validate();" > 
            <div class="change-group">
                <label for="current-password" class="change-label">Current Password</label>
                <input type="password" id="current-password"  name="current_password" placeholder="*****************" >
            </div>
            <div class="change-group">
                <label for="new-password" class="change-label">New Password</label>
                <input type="password" id="new-password"  name="new_password" >
            </div>
            <div class="change-group">
                <label for="confirm-password" class="change-label">Confirm New Password</label>
                <input type="password" id="confirm-password" name="confirm_password" >
            </div>
            <div class="button-container">
                <button type="submit" class="button-save">Save</button>
            </div>
        </form>

        <div class="button-change logout-div" onclick="location.href='logout.php';">
            <p class="logout-button">Log out</p>
        </div>
        <div class="button-change" onclick="document.getElementById('deleteAccountForm').style.display='flex';">
            <p class="delete-button">Delete Account</p>
        </div>

        <!-- Delete Account Form -->
         <div id="deleteAccountForm" class="overlay" style="display: none;">
            <div class="success-box">
                <p class="message" >Are you sure you want to delete your account?</p>
                 <form method="POST" class="delete-form">
                 <p id="delete-detail-message">Once you delete your account, all your data will be permanently lost.</p>
                    <button type="submit" name="delete_account" class="button-delete"><i class="fa-regular fa-x"></i> Yes, Delete my Account</button>
                    <button type="button" onclick="document.getElementById('deleteAccountForm').style.display='none';" class="button-cancel">Cancel</button>
                 </form>  
            </div>
        </div>
    </div>

     <!-- Display success message  -->
     <?php if (isset($_SESSION['successMessage'])): ?>
        <div class="overlay">
            <div class="success-box">
                <p class="message"><?php echo $_SESSION['successMessage']; ?></p>
                <div><i class="fa-regular fa-circle-check"></i></div>
            </div>
        </div>
        <?php unset($_SESSION['successMessage']); ?>
        <script>
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 3000); 
        </script>
    <?php endif; ?>  
</body>
</html>
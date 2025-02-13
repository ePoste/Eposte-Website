<?php 
session_start();
include("connection.php");
include("functions.php");

$errorMessage = ""; // Variable to store the error message

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Retrieve posted data
    $email = $_POST['email'];
    $password = $_POST['pass2'];

    // Check if email already exists in the database
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $query);

    // If email already exists, show an error
    if (mysqli_num_rows($result) > 0) {
        $errorMessage = "This email is already registered. Please use a different email.";
    } else {

        // Save the new user data to the database
        $query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
        mysqli_query($con, $query);



        // Redirect to index page after successful registration
        $user_data["email"] = $email;
        $_SESSION["email"] = $email;
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
    <script src="scripts/validation.js" defer></script>
</head>
<body>
    <div id="login-container">
        <form method="post" id="login-form" onsubmit="return validate();">
            <div id="logo-container">
                <img src="../Logo/eposte.png" alt="Logo" id="logo">
            </div>

            <div class="all-input-group">
                <h2 class="h2-login">Sign Up</h2>

                <div class="input-group">
                    <label for="email">Email</label>
                    <input id="email" type="text" name="email">
                </div>

                <div class="input-group">
                    <label for="pass">Password</label>
                    <input id="pass" type="password" name="pass">
                </div>

                <div class="input-group">
                    <label for="pass2">Re-type Password</label>
                    <input id="pass2" type="password" name="pass2">
                </div>
            </div>

            <button id="login-btn" type="submit">Sign up</button>
            <p class="signup-link">Already have an account? <a href="login.php">Log in</a></p>

            <!-- Display the error message if it exists -->
            <?php if (!empty($errorMessage)): ?>
                <p class="error-message" style="color: red; font-weight: bold; margin-top: 10px; text-align: center;"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>

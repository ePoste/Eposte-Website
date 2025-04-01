<?php 
session_start();
include("connection.php");
include("functions.php");

$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $hashedPassword = $_POST['password']; // SHA-256 hash from JavaScript

    if (!empty($email) && !empty($hashedPassword)) {
        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if ($user_data['password'] === $hashedPassword) {
                $_SESSION['email'] = $user_data['email'];
                header("Location: index.php");
                exit;
            }
        }
        $errorMessage = "Invalid email or password!";
    } else {
        $errorMessage = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../CSS/login.css">
</head>
<body>
    <div id="login-container">
        <form method="post" id="login-form">

            <div id="logo-container">
                <img src="../Logo/eposte.png" alt="Logo" id="logo">
            </div>

            <div class="all-input-group">
                <h2 class="h2-login">Log In</h2>

                <div class="input-group">
                    <label for="email">Email</label>
                    <input id="email" type="text" name="email">
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password">
                </div>
            </div>

            <button id="login-btn" type="submit">Get Started</button>

            <p class="signup-link">Don't have an account? <a href="signup.php">Sign up</a></p>

            <!-- Display the error message if it exists -->
            <?php if (!empty($errorMessage)): ?>
                <p class="error-message" style="color: red; font-weight: bold; margin-top: 10px; text-align: center;"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>

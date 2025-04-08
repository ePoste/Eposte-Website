<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);
$email = $_SESSION["email"];
$errorMessage = "";

if (empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$folderId = intval($_GET['id']);

// Get current folder
$query = "SELECT * FROM folders WHERE folderId = $folderId AND ownerEmail = '$email'";
$result = mysqli_query($con, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    $errorMessage = "Folder not found.";
} else {
    $folder = $result->fetch_assoc();
}

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);
    $delete = isset($_POST["delete"]);

    // Basic validation
    if (strlen($name) > 250 || strlen($description) > 250) {
        $errorMessage = "Name and description must not exceed 250 characters.";
    } elseif ($delete) {
        mysqli_query($con, "DELETE FROM posts WHERE folderId = $folderId");
        mysqli_query($con, "DELETE FROM folders WHERE folderId = $folderId");
        header("Location: index.php");
        exit();
    } else {
        // Check for duplicates (case-insensitive)
        $stmt = $con->prepare("SELECT folderId FROM folders WHERE LOWER(folderName) = LOWER(?) AND ownerEmail = ? AND folderId != ?");
        $stmt->bind_param("ssi", $name, $email, $folderId);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errorMessage = "A folder with that name already exists.";
        } else {
            // All good → Update folder
            $update = $con->prepare("UPDATE folders SET folderName = ?, description = ? WHERE folderId = ?");
            $update->bind_param("ssi", $name, $description, $folderId);
            $update->execute();

            header("Location: index.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Folder</title>
  <link rel="stylesheet" href="../CSS/index.css">
  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>
<body>
  <div class="welcome-container">
    <div class="welcome-content">
      <h2 class="greetings">Edit Folder</h2>
    </div>
    <button class="go-back-button" onclick="window.location.href='index.php';">
    <i class="fa-solid fa-arrow-left"></i> main menu
    </button>

    <?php if (!empty($errorMessage)): ?>
      <p class="error-message" style="color: red; font-weight: bold; text-align: center;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <form method="POST" style="max-width: 500px; margin: auto; padding: 20px;">
      <label for="name">Folder Name</label>
      <input type="text" name="name" id="name" class="search-bar" value="<?php echo htmlspecialchars($folder['folderName']); ?>" maxlength="250" required>

      <br><br>
      <label for="description">Description</label>
      <input type="text" name="description" id="description" class="search-bar" value="<?php echo htmlspecialchars($folder['description']); ?>" maxlength="250">

      <br><br>
      <label for="delete">
        <input type="checkbox" name="delete" id="delete"> Delete this folder
      </label>

      <br><br>
      <input type="submit" class="btn btn-primary" value="Save Changes">
    </form>
  </div>
</body>
</html>

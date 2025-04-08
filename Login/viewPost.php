<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);
$email = $_SESSION["email"];

if (empty($_GET['id'])) {
    echo "Post ID is missing.";
    exit();
}

$postId = intval($_GET['id']);

// Fetch post details
$query = "SELECT * FROM posts WHERE postId = $postId AND ownerEmail = '$email'";
$result = mysqli_query($con, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Post not found or you do not have permission.";
    exit();
}

$post = mysqli_fetch_assoc($result);

// Fetch tags
$tagsQuery = "
    SELECT t.tagName 
    FROM posttags pt 
    JOIN tags t ON pt.tagId = t.tagId 
    WHERE pt.postId = $postId
";
$tagsResult = mysqli_query($con, $tagsQuery);
$tags = [];
while ($row = mysqli_fetch_assoc($tagsResult)) {
    $tags[] = $row['tagName'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Post</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="../CSS/index.css">
  <style>
    .view-container {
      max-width: 600px;
      margin: auto;
      padding: 30px;
    }

    .tag {
      background-color: #6c5ce7;
      color: white;
      padding: 6px 12px;
      border-radius: 20px;
      display: inline-block;
      margin: 4px 4px 0 0;
    }

    .info-label {
      font-weight: bold;
      margin-top: 10px;
      display: block;
    }

    .post-box {
      background: #fefefe;
      padding: 20px;
      border-radius: 16px;
      box-shadow: 0 0 8px rgba(0,0,0,0.08);
    }

    .view-buttons {
      margin-top: 20px;
    }

    .view-buttons a {
      text-decoration: none;
      margin-right: 10px;
      padding: 8px 14px;
      border-radius: 20px;
      background: #1ea7fd;
      color: white;
      font-weight: bold;
    }

    .view-buttons a.back-btn {
      background: #ccc;
      color: black;
    }
  </style>
</head>
<body>

<div class="welcome-container">
  <div class="welcome-content">
    <h2 class="greetings">View Post</h2>
    <div class="logo-container">
      <a href="account.php"><img class="logo" src="../Logo/setting.png" alt="Logo"></a>
    </div>
  </div>
</div>

<div class="view-container">
  <div class="post-box">
    <span class="info-label">Post Name:</span>
    <p><?php echo htmlspecialchars($post['postName']); ?></p>

    <span class="info-label">Description:</span>
    <p><?php echo nl2br(htmlspecialchars($post['postDescription'])); ?></p>

    <span class="info-label">URL:</span>
    <p>
      <?php if (!empty($post['url'])): ?>
        <a href="<?php echo htmlspecialchars($post['url']); ?>" target="_blank"><?php echo htmlspecialchars($post['url']); ?></a>
      <?php else: ?>
        <em>No URL</em>
      <?php endif; ?>
    </p>

    <span class="info-label">Tags:</span>
    <?php if (!empty($tags)): ?>
      <?php foreach ($tags as $tag): ?>
        <span class="tag"><?php echo htmlspecialchars($tag); ?></span>
      <?php endforeach; ?>
    <?php else: ?>
      <p><em>No tags</em></p>
    <?php endif; ?>

    <span class="info-label">Created:</span>
    <p><?php echo htmlspecialchars($post['created']); ?></p>
  </div>

  <div class="view-buttons">
    <a href="editPost.php?id=<?php echo $postId; ?>">Edit Post</a>
    <a href="index.php?id=<?php echo $post['folderId']; ?>" class="back-btn">← Back to Folder</a>
  </div>
</div>

</body>
</html>

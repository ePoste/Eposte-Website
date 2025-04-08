<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);
$email = $_SESSION["email"];

if (empty($_GET['id'])) {
    die("Post ID is missing.");
}

$postId = intval($_GET['id']);
$error = "";

// Fetch post info
$postRes = mysqli_query($con, "SELECT * FROM posts WHERE postId = $postId AND ownerEmail = '$email'");
if (!$postRes || mysqli_num_rows($postRes) === 0) {
    die("Post not found or unauthorized access.");
}
$post = mysqli_fetch_assoc($postRes);

// Fetch current tags
$tagRes = mysqli_query($con, "
  SELECT t.tagName 
  FROM posttags pt 
  JOIN tags t ON pt.tagId = t.tagId 
  WHERE pt.postId = $postId
");
$currentTags = [];
while ($tag = mysqli_fetch_assoc($tagRes)) {
    $currentTags[] = $tag['tagName'];
}

// Fetch all folders
$folders = mysqli_query($con, "SELECT * FROM folders WHERE ownerEmail = '$email'");

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $folderId = $_POST["folder"];
    $postName = trim($_POST["postName"]);
    $postDescription = trim($_POST["postDescription"]);
    $url = trim($_POST["url"]);
    $tagsRaw = $_POST["tags"];

    if ($folderId && $postName) {
        // Update post
        $stmt = $con->prepare("UPDATE posts SET folderId = ?, postName = ?, postDescription = ?, url = ? WHERE postId = ?");
        $stmt->bind_param("isssi", $folderId, $postName, $postDescription, $url, $postId);
        $stmt->execute();

        // Remove old tags
        mysqli_query($con, "DELETE FROM posttags WHERE postId = $postId");

        // Re-add updated tags
        $tagList = array_filter(array_map('trim', explode(",", $tagsRaw)));
        foreach ($tagList as $tagName) {
            $tagName = strtolower($tagName);
            $safeTag = mysqli_real_escape_string($con, $tagName);
            if (!empty($safeTag)) {
                $tagCheck = mysqli_query($con, "SELECT tagId FROM tags WHERE tagName = '$safeTag'");
                if (mysqli_num_rows($tagCheck) == 0) {
                    mysqli_query($con, "INSERT INTO tags (tagName) VALUES ('$safeTag')");
                    $tagId = mysqli_insert_id($con);
                } else {
                    $tagId = mysqli_fetch_assoc($tagCheck)['tagId'];
                }
                mysqli_query($con, "INSERT INTO posttags (postId, tagId) VALUES ($postId, $tagId)");
            }
        }

        header("Location: viewPost.php?id=$postId");
        exit();
    } else {
        $error = "Post name and folder are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Post</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="../CSS/index.css">
  <style>
    <?php // same CSS as your create post page for consistency ?>
    .form-container { max-width: 500px; margin: auto; padding: 20px; }
    .form-group { margin-bottom: 20px; }
    .form-group input, .form-group textarea, .form-group select {
      width: 100%; padding: 10px; border-radius: 12px; border: 1px solid #ccc; background: #f5f5f5;
    }
    .form-actions { display: flex; justify-content: space-between; }
    .btn-save { background-color: #1ea7fd; color: white; border: none; padding: 10px 20px; border-radius: 20px; cursor: pointer; }
    .btn-reset { background-color: #eee; color: black; border: none; padding: 10px 20px; border-radius: 20px; cursor: pointer; }
    .tag-container { display: flex; flex-wrap: wrap; gap: 8px; background: #f5f5f5; padding: 8px; border-radius: 12px; }
    .tag-container input { border: none; background: transparent; outline: none; flex-grow: 1; min-width: 100px; }
    .tag { background-color: #6c5ce7; color: white; padding: 6px 12px; border-radius: 20px; display: flex; align-items: center; }
    .tag .remove-tag { margin-left: 8px; cursor: pointer; }
  </style>
</head>
<body>

<div class="welcome-container">
  <div class="welcome-content">
    <h2 class="greetings">Edit Post</h2>
    <div class="logo-container">
      <a href="account.php"><img class="logo" src="../Logo/setting.png" alt="Logo"></a>
    </div>
  </div>
  <button onclick="window.location.href='viewPost.php?id=<?php echo $postId ?>';" class="btn btn-secondary">← Back to Post</button>

  <?php if (!empty($error)): ?>
    <p style="color: red; font-weight: bold; text-align: center;"><?php echo $error; ?></p>
  <?php endif; ?>

  <form method="POST" class="form-container">
    <div class="form-group">
      <label for="postName">Filename</label>
      <input type="text" name="postName" value="<?php echo htmlspecialchars($post['postName']); ?>" required>
    </div>

    <div class="form-group">
      <label for="url">URL</label>
      <input type="url" name="url" value="<?php echo htmlspecialchars($post['url']); ?>">
    </div>

    <div class="form-group">
      <label for="tags">Tags</label>
      <div class="tag-container" id="tagContainer">
        <input type="text" id="tagInput" placeholder="add tags..." autocomplete="off" />
      </div>
      <input type="hidden" name="tags" id="tagsHidden">
    </div>

    <div class="form-group">
      <label for="folder">Move To</label>
      <select name="folder" required>
        <?php while ($folder = mysqli_fetch_assoc($folders)): ?>
          <option value="<?php echo $folder['folderId']; ?>" <?php if ($folder['folderId'] == $post['folderId']) echo 'selected'; ?>>
            <?php echo $folder['folderName']; ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="postDescription">Description</label>
      <textarea name="postDescription" maxlength="250"><?php echo htmlspecialchars($post['postDescription']); ?></textarea>
    </div>

    <div class="form-actions">
      <input type="submit" class="btn-save" value="Update">
      <input type="reset" class="btn-reset" value="Reset">
    </div>
  </form>
  <form method="POST" action="deletePost.php" onsubmit="return confirm('Are you sure you want to delete this post? This cannot be undone.');" style="margin-top: 30px; text-align: center;">
    <input type="hidden" name="postId" value="<?php echo $postId; ?>">
    <button type="submit" style="background-color: #e74c3c; color: white; border: none; padding: 10px 20px; border-radius: 20px; cursor: pointer;">
        🗑️ Delete Post
    </button>
</form>
</div>

<script>
const tagInput = document.getElementById("tagInput");
const tagContainer = document.getElementById("tagContainer");
const tagsHidden = document.getElementById("tagsHidden");
const suggestionsBox = document.createElement("div");
suggestionsBox.className = "tag-suggestions";
tagContainer.appendChild(suggestionsBox);

let tags = <?php echo json_encode($currentTags); ?>;

function renderTags() {
  tagContainer.querySelectorAll(".tag").forEach(tag => tag.remove());
  tags.forEach((tag, i) => {
    const tagEl = document.createElement("span");
    tagEl.classList.add("tag");
    tagEl.innerHTML = `${tag} <span class="remove-tag" data-index="${i}">&times;</span>`;
    tagContainer.insertBefore(tagEl, tagInput);
  });
  tagsHidden.value = tags.join(",");
}

tagInput.addEventListener("keydown", function (e) {
  if (e.key === "Enter" || e.key === ",") {
    e.preventDefault();
    let value = tagInput.value.trim().toLowerCase();
    if (value && !tags.includes(value)) {
      tags.push(value);
      renderTags();
    }
    tagInput.value = "";
    suggestionsBox.style.display = "none";
  }
});

tagInput.addEventListener("input", async function () {
  const query = tagInput.value.trim();
  if (query.length === 0) {
    suggestionsBox.style.display = "none";
    return;
  }

  const res = await fetch(`getTags.php?q=${encodeURIComponent(query)}`);
  const suggestions = await res.json();
  renderSuggestions(suggestions);
});

function renderSuggestions(suggestions) {
  suggestionsBox.innerHTML = "";
  if (suggestions.length === 0) {
    suggestionsBox.style.display = "none";
    return;
  }

  suggestions.forEach(s => {
    const div = document.createElement("div");
    div.textContent = s;
    div.onclick = () => {
      if (!tags.includes(s)) {
        tags.push(s);
        renderTags();
      }
      tagInput.value = "";
      suggestionsBox.style.display = "none";
    };
    suggestionsBox.appendChild(div);
  });

  suggestionsBox.style.display = "block";
}

tagContainer.addEventListener("click", function (e) {
  if (e.target.classList.contains("remove-tag")) {
    tags.splice(e.target.dataset.index, 1);
    renderTags();
  }
});

window.onload = renderTags;
</script>


</body>
</html>

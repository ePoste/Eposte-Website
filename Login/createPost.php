<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);
$email = $_SESSION["email"];
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $folderId = $_POST["folder"];
    $postName = trim($_POST["postName"]);
    $postDescription = trim($_POST["postDescription"]);
    $url = trim($_POST["url"]);
    $tagsRaw = $_POST["tags"];
    $created = date("Y-m-d");

    if ($folderId && $postName) {
        $stmt = $con->prepare("INSERT INTO posts (ownerEmail, folderId, postName, postDescription, url, created) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissss", $email, $folderId, $postName, $postDescription, $url, $created);
        $stmt->execute();
        $postId = $stmt->insert_id;

        // Tag insert logic
        $tagList = array_filter(array_map('trim', explode(",", $tagsRaw)));
        
        foreach ($tagList as $tagName) {
            $tagName = strtolower($tagName);
            if (!empty($tagName)) {
                // Escape to prevent SQL issues
                $safeTag = mysqli_real_escape_string($con, $tagName);
        
                // Check if tag already exists
                $tagRes = mysqli_query($con, "SELECT tagId FROM tags WHERE tagName = '$safeTag'");
                if (mysqli_num_rows($tagRes) === 0) {
                    mysqli_query($con, "INSERT INTO tags (tagName) VALUES ('$safeTag')");
                    $tagId = mysqli_insert_id($con);
                } else {
                    $tagId = mysqli_fetch_assoc($tagRes)['tagId'];
                }
        
                // Create relation
                mysqli_query($con, "INSERT INTO posttags (postId, tagId) VALUES ('$postId', '$tagId')");
            }
        }

        header("Location: index.php?id=$folderId");
        exit();
    } else {
        $error = "Please select a folder and enter a post name.";
    }
}

$folders = mysqli_query($con, "SELECT * FROM folders WHERE ownerEmail = '$email' ORDER BY created DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Post</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="../CSS/index.css">
  <style>
    .form-container {
      max-width: 500px;
      margin: auto;
      padding: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 10px;
      border-radius: 12px;
      border: 1px solid #ccc;
      background: #f5f5f5;
    }

    .form-actions {
      display: flex;
      justify-content: space-between;
    }

    .btn-save {
      background-color: #1ea7fd;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 20px;
      cursor: pointer;
    }

    .btn-reset {
      background-color: #eee;
      color: black;
      border: none;
      padding: 10px 20px;
      border-radius: 20px;
      cursor: pointer;
    }

    .tag-container {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      background: #f5f5f5;
      padding: 8px;
      border-radius: 12px;
    }

    .tag-container input {
      border: none;
      background: transparent;
      outline: none;
      flex-grow: 1;
      min-width: 100px;
    }

    .tag {
      background-color: #6c5ce7;
      color: white;
      padding: 6px 12px;
      border-radius: 20px;
      display: flex;
      align-items: center;
    }

    .tag .remove-tag {
      margin-left: 8px;
      cursor: pointer;
    }

    .tag-suggestions {
  position: absolute;
  background: white;
  border: 1px solid #ccc;
  z-index: 10;
  border-radius: 6px;
  width: 100%;
  max-height: 150px;
  overflow-y: auto;
  display: none;
}

.tag-suggestions div {
  padding: 8px 12px;
  cursor: pointer;
}

.tag-suggestions div:hover {
  background-color: #f0f0f0;
}

  </style>
</head>
<body>

<div class="welcome-container">
  <div class="welcome-content">
    <h2 class="greetings">Create Post</h2>
    <div class="logo-container">
      <a href="account.php"><img class="logo" src="../Logo/setting.png" alt="Logo"></a>
    </div>
  </div>

  <button onclick="window.location.href='index.php';" class="btn btn-secondary">← Back to Dashboard</button>

  <?php if (!empty($error)): ?>
    <p style="color: red; font-weight: bold; text-align: center;"><?php echo $error; ?></p>
  <?php endif; ?>

  <form method="POST" class="form-container">
    <div class="form-group">
      <label for="postName">Filename</label>
      <input type="text" name="postName" id="postName" placeholder="rename here ..." maxlength="250" required>
    </div>

    <div class="form-group">
      <label for="url">URL</label>
      <input type="url" name="url" id="url" placeholder="www.website.com" maxlength="500">
    </div>

    <div class="form-group">
      <label for="tags">Tag</label>
        <div class="tag-container" id="tagContainer">
           <input type="text" id="tagInput" placeholder="add tags..." autocomplete="off" />
        <div id="tagSuggestions" class="tag-suggestions"></div>
    </div>
  <input type="hidden" name="tags" id="tagsHidden">
</div>


    <div class="form-group">
      <label for="folder">Move To</label>
      <select name="folder" id="folder" required>
        <option value="">Move file to...</option>
        <?php while ($folder = mysqli_fetch_assoc($folders)): ?>
          <option value="<?php echo $folder['folderId']; ?>"><?php echo $folder['folderName']; ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="postDescription">Description</label>
      <textarea name="postDescription" id="postDescription" placeholder="Description here....." maxlength="250"></textarea>
      <small style="float:right; font-size:12px;">max 250 characters</small>
    </div>

    <div class="form-actions">
      <input type="submit" class="btn-save" value="save">
      <input type="reset" class="btn-reset" value="reset">
    </div>
  </form>
</div>

<script>
const tagInput = document.getElementById("tagInput");
const tagContainer = document.getElementById("tagContainer");
const tagsHidden = document.getElementById("tagsHidden");
const suggestionsBox = document.getElementById("tagSuggestions");
let tags = [];

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
</script>


</body>
</html>

<?php
include("connection.php");

if (isset($_GET['q'])) {
    $q = strtolower(trim($_GET['q']));
    $result = mysqli_query($con, "SELECT tagName FROM tags WHERE tagName LIKE '$q%' LIMIT 10");

    $tags = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tags[] = $row['tagName'];
    }

    header('Content-Type: application/json');
    echo json_encode($tags);
}
?>

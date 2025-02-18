<?php 

require_once 'core/handleForms.php';
require_once 'core/models.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Document</title>
</head>
<body>

<style>
body {
    background: #ffffff; /* Override any inherited styles */
    margin: 0;
}
</style>

<?php

    $searchUserResults = isset($_SESSION['searchUserResults']) ? $_SESSION['searchUserResults'] : [];
    $postsUser = empty($searchUserResults) ? getAllPostsOfUser($pdo, $_SESSION['fname'], $_SESSION['lname']) : $searchUserResults;

?>


<?php foreach($postsUser as $post) : ?>

<div class="post_container">
    <h3 style="color: #004E98;"><?php echo $post['post_title']; ?></h3>
    <p><?php echo $post['post_desc']; ?></p>
    <h4 style="color: #00ffff;">Posted by: <?php echo $post['fname'] . " " . $post['lname']; ?></h4>
    <a href="deletePost.php?postID=<?php echo htmlspecialchars($post['postID']); ?>" style="text-decoration: none;" target="_top" id="deletePostButton">Delete</a>
    <a href="checkApplications.php?postID=<?php echo htmlspecialchars($post['postID']); ?>" style="text-decoration: none;" id="checkApplicationsButton" target="_top">Check Applications</a>
</div>

<br>

<?php endforeach; ?>

<br>
</body>
</html>
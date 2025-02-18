<?php 

require_once 'core/dbConfig.php';
require_once 'core/handleForms.php';

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
    margin: 0;
    font-family: Arial, sans-serif;

    /* Add a background color with double gradients */
    background: linear-gradient(to bottom, #ffffff 80%, transparent),
                linear-gradient(to bottom, #20adad 100%, rgba(255, 0, 0, 0) 110%);
    height: 100%;  /* Make sure the body takes up the full viewport height */
    background-attachment: fixed;  /* Keeps the background fixed during scrolling */
}

</style>

    <!-- Navbar -->
    <div class="nav_bar">
        <span class="logo_container">
            <img src="resources/Web.logo.jpg" alt="findhire_logo" id="logo">
        </span>
    </div>

<br><br>

    <div id="createPostForm">
        <?php 
            if(isset($_SESSION['message'])) { ?>
                <div class="message"><?php echo $_SESSION['message']; ?></div>
            <?php unset($_SESSION['message']); }
        ?>
        <h2 style="color: #004E98;">Write a job post</h2>
        <form action="core/handleForms.php" method="POST">
            <label for="post_title">Job Title</label>
            <input type="text" name="post_title" id="post_title">
            <br><br>

            <label for="post_desc">Job Description</label><br>
            <textarea name="post_desc" id="post_desc" cols="60" rows="10"></textarea>
            <br><br>

            <input type="submit" value="Post" name="createPostBtn" id="createPostButton"><br><br>
            <a href="HRHome.php" style="text-decoration: none;" id="cancelButton">Cancel</a>
        </form>
    </div>
</body>
</html>
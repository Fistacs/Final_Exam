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
    <title>Home</title>
</head>
<body>

<div class="nav_bar">
        <span class="logo_container">
            <img src="resources/Web.logo.jpg" alt="findhire_logo" id="logo">
        </span>
</div>

<script>
    window.addEventListener('message', (event) => {
        if (event.data === 'post_deleted') {
            // Trigger a page reload
            window.location.reload();
        }
    });
</script>

<br>

<div class="hrMain">

    <section class="searchUserCreatedResults_form">
        
        <h2 style="color: #20adad;">Job/s posted</h2>
        
        <form action="core/handleForms.php" method="POST">
                <input type="text" name="search" placeholder="Search for a job post:" class="searchJobUserInput">
                <input type="submit" value="Search" name="searchJobUserBtn" class="searchJobUserButton">
                <a href="createPost.php" style="text-decoration: none; color: #ffffff;" id="createPostButton">Create A Post</a>
        </form><br><br>

        <iframe src="searchUserCreatedResults.php" frameborder="1" class="posts_frame" style="background-color: #ffffff;"></iframe>
    </section>

<?php
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'hr') {
        header('Location: ApplicantHome.php');
        exit();
    }
    
    if (isset($_SESSION['fname'])) { ?>
    <div class="account_container">
        <div class="account"><h3 style="color: white;">Hello, <?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?>!</h3>
        <form action="core/logout.php" method="POST">
            <button type="submit" class="logout_button">Logout</button>
        </form>
        </div>
    </div>
    <?php } else {
    header('Location: login.php');
    exit();  // Stop execution after redirecting to login
    }
?>

    <br><br><br><br><br>

</div>

<div class="searchJobs">
    
    <h2 style="color: #20adad;">Jobs Posted by Other HR</h2>

    <form action="core/handleForms.php" method="POST">
        <input type="text" name="search" placeholder="Search for a job post:" class="searchJobUserInput">
        <input type="submit" value="Search" name="searchJobBtn" class="searchJobUserButton">
    </form><br><br>

    <iframe src="searchResults.php" frameborder="1" class="posts_frame" style="background-color: #ffffff;"></iframe>

</div>

</body>
</html>
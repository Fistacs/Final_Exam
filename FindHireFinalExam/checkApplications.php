<?php

require_once 'core/dbConfig.php';
require_once 'core/handleForms.php';
require_once 'core/models.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Check Applications</title>
</head>

<body>

    <!-- Navbar -->
    <div class="nav_bar">
        <span class="logo_container">
            <img src="resources/Web.logo.jpg" alt="web_logo" id="logo">
        </span>
    </div>

    <?php
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'hr') {
            header('Location: ApplicantHome.php');
            exit();
        }

        if (isset($_SESSION['fname'])) { ?>
            <div id="applicant_account_container">
                <div id="applicant_account">
                    <h3 style="color: white;">Hello, <?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?>!</h3>
                </div>
                <form action="core/logout.php" method="POST" style="margin: -6em 0 0 -2em;">
                    <button type="submit" class="logout_button">Logout</button>
                </form>
            </div>
        <?php } else {
            header('Location: login.php');
            exit();
        }

        // Check if postID is provided in the URL
        if (!isset($_GET['postID'])) {
            echo "Error: No job post selected.";
            exit();
        }

        $postID = $_GET['postID'];
        $postTitle = getPostById($pdo, $postID);
        $applications = getApplicationsByPostID($pdo, $postID);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $applicationID = $_POST['applicationID'];
            $action = $_POST['action'];

            if ($action === 'accept') {
                acceptApplication($pdo, $applicationID);
            }   
            elseif ($action === 'reject') {
                rejectApplication($pdo, $applicationID);
            }

            // Refresh the page to update the application list
            header("Location: checkApplications.php?postID=" . htmlspecialchars($postID));
            exit();
        }

        // Fetch all accepted applications
        $acceptedApplications = getAcceptedApplicationsByPostID($pdo, $postID);
    ?>

    <div class="wrapper">
        <div class="main">
            <div id="checkApplicationsContainer">
                <h2 style="color: #00ffff;">Applications for <?php echo htmlspecialchars($postTitle['post_title']); ?></h2>
                
                <?php if (empty($applications)): ?>
                    <p>No applications found for this job post.</p>
                <?php else: ?>
                    <?php foreach ($applications as $application) : ?>
                        <div class="post_container">
                            <p><strong>Applicant:</strong> <?php echo htmlspecialchars($application['fname'] . ' ' . $application['lname']); ?></p>
                            <p><strong>Message:</strong> <?php echo htmlspecialchars($application['applicant_message']); ?></p>
                            <p><strong>Resume:</strong> <a href="resumePath/<?php echo htmlspecialchars($application['resumeFilePath']); ?>" target="_blank">Download</a></p>

                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="applicationID" value="<?php echo htmlspecialchars($application['applicationID']); ?>">
                                <button type="submit" name="action" value="accept" id="acceptButton" class="form-button">Accept</button>
                                <button type="submit" name="action" value="reject" id="rejectButton" class="form-button">Reject</button>
                                <a href="Messenger.php?accountID=<?php echo htmlspecialchars($application['accountID']); ?>&postID=<?php echo $postID; ?>" style="text-decoration: none;" id="sendMessageButton" class="form-button">Message Applicant</a>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <br><br>

                <h2 style="color: #ff822f;">Accepted Applications:</h2>
                
                <?php if (!empty($acceptedApplications)) : ?>
                    <?php foreach ($acceptedApplications as $application) : ?>
                        <div class="accepted_applicant">
                            <p><strong>Applicant:</strong> <?php echo htmlspecialchars($application['fname'] . ' ' . $application['lname']); ?></p>
                            <a href="Messenger.php?accountID=<?php echo htmlspecialchars($application['accountID']); ?>&postID=<?php echo $postID; ?>" style="text-decoration: none;" id="sendMessageButton" class="form-button">Message Applicant</a>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No applications accepted for this job post.</p>
                <?php endif; ?>

                <br>

                <a href="HRHome.php" style="text-decoration: none;" class="form-cancel-button">Return</a>
            </div>
        </div>
    </div>

</body>
</html>

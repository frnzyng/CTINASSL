<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSite - Home</title>
</head>
<body>

    <!-- Navigation Bar -->
    <div>
        <header>        
            <nav>
                <h3>BLOGSITE</h3>
                <a href="user-login.php">Logout</a>
                <?php
                    include("../controller/SessionController.php");
                    $sessionController = new SessionController();

                    // Check if the account ID exists before displaying
                    $accountId = $sessionController->getAccountId();

                    if ($accountId !== null) {
                        echo "<h3> Hi " . $accountId . "! </h3>";
                    } else {
                        echo "<h3>Not logged in</h3>";
                    }
                ?>
            </nav>
        </header>
    </div>

    <div class="create-post-container">
        <h2>Create Post</h2>
        <?php

        // Display any error messages
        if (isset($_SESSION["error_message"])) {
            echo $_SESSION["error_message"];
            unset($_SESSION["error_message"]); // Clear the error message from session
        }
        ?>
        <form action="../controller/UserHomeController.php?action=handlePostSubmission" method="post">
            <label for="post_topic">Post Topic:</label>
            <input type="text" name="post_topic" id="post_topic" maxlength="50" required>
            <br>

            <label for="post_content">Post Content:</label>
            <textarea name="post_content" id="post_content" rows="5" maxlength="250" required></textarea>
            <br>
    
            <input type="submit" value="Post">
        </form>
    </div>

    <?php
    // Include the UserPostModel and get the posts; No need to create an instance since the method is static
    include("../controller/UserHomeController.php");
    $posts = UserHomeController::handlePostRetrieval();
    ?>

    <!-- Displaying posts in HTML -->
    <div>
        <h2>All Posts</h2>
        <?php foreach ($posts as $post): ?>
            <div>
                <h3><?php echo $post['post_topic']; ?></h3>
                <p><?php echo $post['post_date']; ?></p>
                <h3><?php echo $post['account_id']; ?></h3>
                <p><?php echo $post['post_content']; ?></p>
                <form action="../controller/UserHomeController.php?action=handlePostSubmission" method="post">
                    <label for="post_topic">Comments</label>
                    <input type="text" name="post_topic" id="post_topic" maxlength="50" required>
                    <input type="submit" value="Comment">
                </form>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>

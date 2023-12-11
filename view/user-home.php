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
                    $accountUsername = $sessionController->getUsername();

                    if ($accountUsername !== null) {
                        echo "<h3> Hi " . $accountUsername . "! </h3>";
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

    <!-- Displaying posts and comments -->
    <?php include("../controller/UserHomeController.php"); ?>
    <div>
        <h2>All Posts</h2>
        <?php
            try {
                $posts = UserHomeController::handlePostRetrieval();
            } catch (Exception $e) {
                echo "Error retrieving posts: " . $e->getMessage();
                // Handle the error gracefully, maybe display a user-friendly message
            }
        ?>
        <?php foreach ($posts as $post): ?>
            <div>
                <h3><?php echo $post['post_topic']; ?></h3>
                <p><?php echo $post['post_datetime']; ?></p>
                <h3><?php echo $post['account_id']; ?></h3>
                <h3><?php echo $post['username']; ?></h3>
                <p><?php echo $post['post_content']; ?></p>

                <form action="../controller/UserHomeController.php?action=handleCommentSubmission" method="post">
                    <label>Comments</label>
                    <textarea name="comment_content" id="comment_content" maxlength="50" required></textarea>
                    <input type="hidden" name="post_id" id="post_id" value="<?php echo $post['post_id']; ?>">
                    <input type="submit" value="Comment">
                </form>

                <?php
                    try {
                        // Get comments for the current post
                        $comments = UserHomeController::handleCommentRetrieval($post['post_id']);
                    } catch (Exception $e) {
                        echo "Error retrieving comments: " . $e->getMessage();
                    }
                ?>
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div>
                            <h3><?php echo $comment['comment_id']; ?></h3>
                            <p><?php echo $comment['post_id']; ?></p>
                            <h3><?php echo $comment['account_id']; ?></h3>
                            <h3><?php echo $comment['username']; ?></h3>
                            <h3><?php echo $comment['comment_datetime']; ?></h3>
                            <p><?php echo $comment['comment_content']; ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No comments for this post.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>



</body>
</html>

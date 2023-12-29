<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSite - User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/user-profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1f47064a19.js" crossorigin="anonymous"></script>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="container px-0 fixed-top bg-white">
        <header>        
            <nav class="nav justify-content-between align-items-center">
                <?php
                    include_once("../controller/SessionController.php");
                    $sessionController = new SessionController();

                    // Check if the account username exists before displaying
                    $accountUsername = $sessionController->getUsername();

                    if ($accountUsername !== null) {
                        echo "<span class='greetings-container'> Hi " . $accountUsername . "! </span>";
                    } else {
                        echo "<span class='greetings-container'>Not logged in</span>";
                    }
                ?>
                <ul class="nav justify-content-between">
                    <li class="nav-item">
                        <a href="user-home.php"><i class="fa-solid fa-house"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="user-profile.php"><i class="fa-solid fa-user"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="user-settings.php"><i class="fa-solid fa-gear"></i></a>
                    </li>
                </ul>

                <a class="logout-container" href="user-login.php">Logout</a>
            </nav>
        </header>
    </div>

    <div class="container px-0">
        <div class="row justify-content-center align-items-center mx-2">
            <div class="create-post-container">
                <?php
                    // Display any status messages
                    if (isset($_SESSION["success_message"])) {
                        echo $_SESSION["success_message"];
                        unset($_SESSION["success_message"]); // Clear the error message from session
                    }
                    else if (isset($_SESSION["error_message"])) {
                        echo $_SESSION["error_message"];
                        unset($_SESSION["error_message"]); // Clear the error message from session
                    }
                ?>
                
                <h4>Create Post</h4>
                <form class="post-form" action="../controller/UserProfileController.php?action=handlePostSubmission" method="post">
                    <div class="topic-container">
                        <label for="post_topic">Topic</label>
                        <input class="topic-input" type="text" name="post_topic" id="post_topic" maxlength="50" required placeholder="What's on your mind?">
                    </div>  
                    <div class="content-container">
                        <label for="post_content">Content</label>
                        <textarea class="content-input" name="post_content" id="post_content" rows="5" maxlength="250" required placeholder="Tell us more about it!"></textarea>
                    </div>
                    <div class="button-container">
                        <button class="cancel-button">Cancel</button>
                        <input class="submit-button" type="submit" value="Post">
                    </div>
                </form>
            </div>
        </div>

        <!-- Displaying posts and comments -->
        <div class="row justify-content-center align-items-center mx-2">
            <?php include_once("../controller/UserProfileController.php"); ?>
            <div class="post-block">
                <div class="heading">
                    <h4>User Profile</h4>
                    <button class="create-post-button">Create Post</button>
                </div>
                <?php
                    try {
                        $userProfileController = new UserProfileController();
                        $posts = UserProfileController::handlePostRetrieval();
                    } 
                    catch (Exception $e) {
                        echo "Error retrieving posts: " . $e->getMessage();
                    }
                ?>

                <?php foreach ($posts as $post): ?>
                    <div class="post-container">
                        <div class="section1-post">
                            <h5><?php echo $post['post_topic']; ?></h5>
                            <a class="post-settings-button"><i class="fa-solid fa-ellipsis"></i></a>
                        </div>

                        <div class="section2-post">
                            <p class="post-username">Posted by <?php echo $post['username'] . " - " . $userProfileController->timeAgo($post['post_datetime']); ?></p>
                            <p class="post-content"><?php echo $post['post_content']; ?></p>
                            <a class="create-comment-button"><i class="fa-solid fa-message"></i></a>
                        </div>
                    </div>

                    <div class="comments-block">
                        <h5>Comments</h5>
                        <?php
                            // Display any status messages
                            if (isset($_SESSION["success_message"])) {
                                echo $_SESSION["success_message"];
                                unset($_SESSION["success_message"]); // Clear the error message from session
                            }
                            else if (isset($_SESSION["error_message"])) {
                                echo $_SESSION["error_message"];
                                unset($_SESSION["error_message"]); // Clear the error message from session
                            }
                        ?>
                        <form class="comment-form" action="../controller/UserProfileController.php?action=handleCommentSubmission" method="post">
                            <input class="comment-input" type="text" name="comment_content" id="comment_content" rows="1" maxlength="50" required placeholder="Write a comment..."></input>
                            <input type="hidden" name="post_id" id="post_id" value="<?php echo $post['post_id']; ?>">
                            <input class="submit-button" type="submit" value="Comment">
                        </form>

                        <?php
                            try {
                                // Get comments for the current post
                                $comments = UserProfileController::handleCommentRetrieval($post['post_id']);
                            } catch (Exception $e) {
                                echo "Error retrieving comments: " . $e->getMessage();
                            }
                        ?>
                        <?php if (!empty($comments)): ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="comments-container">
                                    <div class="section1-comment">
                                        <span class="comment-username"><?php echo $comment['username']; ?></span>
                                        <a class="comment-settings-button"><i class="fa-solid fa-ellipsis"></i></a>
                                    </div>
                                    <p class="comment-datetime"><?php echo $userProfileController->timeAgo($comment['comment_datetime']); ?></p>
                                    <p class="comment-content"><?php echo $comment['comment_content']; ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No comments for this post.</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    

    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

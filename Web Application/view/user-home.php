<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSite - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/user-home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1f47064a19.js" crossorigin="anonymous"></script>
    <!-- TOGGLE EDIT FORM -->
    <script>
        function toggleEditForm(post_id) {
            var editPost = document.getElementById('edit-post-container' + post_id);
            var post = document.getElementById('post-container' + post_id);
            editPost.style.display = (editPost.style.display === 'none') ? 'block' : 'none';
            post.style.display = (post.style.display === 'block') ? 'none' : 'block';
        }
    </script>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="container px-0 fixed-top bg-white">
        <header>        
            <nav class="nav justify-content-center align-items-center mx-3">
                <?php
                    include_once("../controller/SessionController.php");
                    $sessionController = new SessionController();

                    // Check if the account ID exists before displaying
                    $accountUsername = $sessionController->getUsername();

                    if ($accountUsername !== null) {
                        echo "<span class='greetings'> Hi " . $accountUsername . "! </span>";
                    } else {
                        echo "<span class='greetings'>Not logged in</span>";
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

                <form action="../controller/UserAuthController.php?action=handleLogout" method="post">
                    <button class="logout-button" type="submit">Logout</button>
                </form>
            </nav>
        </header>
    </div>

    <div class="container px-0">
        <div class="row justify-content-center align-items-center mx-2">
            <div class="create-post-container">   
                <h4>Create Post</h4>

                

                <form class="post-form" action="../controller/UserHomeController.php?action=handlePostSubmission" method="post">
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
            <?php include_once("../controller/UserHomeController.php"); ?>
            <div class="post-block">
                <div class="heading">
                    <h4>All Posts</h4>
                    <button class="create-post-button">Create Post</button>
                </div>
                <?php
                    try {
                        $userHomeController = new UserHomeController();
                        $posts = UserHomeController::handlePostRetrieval();
                    } 
                    catch (Exception $e) {
                        echo "Error retrieving posts: " . $e->getMessage();
                    }
                ?>

                <p class="status-message">
                    <?php
                        // Display any status messages
                        if (isset($_SESSION["success_messagePost"])) {
                            echo $_SESSION["success_messagePost"];
                            unset($_SESSION["success_messagePost"]); // Clear the error message from session
                        }
                        else if (isset($_SESSION["error_messagePost"])) {
                            echo $_SESSION["error_messagePost"];
                            unset($_SESSION["error_messagePost"]); // Clear the error message from session
                        }
                        else if (isset($_SESSION["success_messageDeletePost"])) {
                            echo $_SESSION["success_messageDeletePost"];
                            unset($_SESSION["success_messageDeletePost"]); // Clear the error message from session
                        }
                        else if (isset($_SESSION["error_messageDeletePost"])) {
                            echo $_SESSION["error_messageDeletePost"];
                            unset($_SESSION["error_messageDeletePost"]); // Clear the error message from session
                        }
                    ?>
                </p>

                <?php foreach ($posts as $post): ?>
                    <div class="post-container" id="post-container<?php echo $post['post_id']; ?>" style="display: block;">
                        <div class="section1-post">
                            <h5><?php echo $post['post_topic']; ?></h5>
                            <a class="post-settings-button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis"></i>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="toggleEditForm(<?php echo $post['post_id']; ?>)">Edit post</a>
                                    </li>
                                    <li>
                                        <?php if ($post['username'] == $sessionController->getUsername()) { ?>
                                            <form action="../controller/UserHomeController.php?action=handleDeletePost" method="post" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                <input type="hidden" name="post_id" id="post_id" value="<?php echo $post['post_id']; ?>">
                                                <button class="dropdown-item" type="submit">Delete post</button>
                                            </form>
                                        <?php } else { ?>
                                            <form action="../controller/UserHomeController.php?action=handleDeletePost" method="post" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                <input type="hidden" name="post_id" id="post_id" value="<?php echo $post['post_id']; ?>">
                                                <button class="dropdown-item" type="submit" disabled >Delete post</button>
                                            </form>
                                        <?php } ?>
                                    </li>
                                </ul>
                            </a>
                        </div>

                        <div class="section2-post">
                            <p class="post-username">Posted by <?php echo $post['username'] . " - " . $userHomeController->timeAgo($post['post_datetime']); ?></p>
                            <p class="post-content"><?php echo $post['post_content']; ?></p>
                            <a class="create-comment-button"><i class="fa-solid fa-message"></i></a>
                        </div>
                    </div>

                    <div class="edit-post-container" id="edit-post-container<?php echo $post['post_id']; ?>" style="display: none;">   
                        <h4>Edit Post</h4>
                        <form class="post-form" id="edit-post-container" action="../controller/UserHomeController.php?action=handlePostSubmission" method="post">
                            <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                            <div class="topic-container">
                                <label for="post_topic">Topic</label>
                                <input class="edit-topic-input" type="text" name="post_topic" id="post_topic" maxlength="50" required value="<?php echo $post['post_topic']; ?>">
                            </div>  
                            <div class="content-container">
                                <label for="post_content">Content</label>
                                <textarea class="edit-content-input" name="post_content" id="post_content" rows="5" maxlength="250" required><?php echo $post['post_content']; ?></textarea>
                            </div>
                            <div class="button-container">
                                <button class="cancel-button">Cancel</button>
                                <input class="submit-button" type="submit" value="Post">
                            </div>
                        </form>
                    </div>

                    <div class="comments-block">
                        <h5>Comments</h5>
                        <p class="status-message">
                            <?php
                                // Display any status messages
                                if (isset($_SESSION["success_messageComment"])) {
                                    echo $_SESSION["success_messageComment"];
                                    unset($_SESSION["success_messageComment"]); // Clear the error message from session
                                }
                                else if (isset($_SESSION["error_messageComment"])) {
                                    echo $_SESSION["error_messageComment"];
                                    unset($_SESSION["error_messageComment"]); // Clear the error message from session
                                }
                                else if (isset($_SESSION["success_messageDeleteComment"])) {
                                    echo $_SESSION["success_messageDeleteComment"];
                                    unset($_SESSION["success_messageDeleteComment"]); // Clear the error message from session
                                }
                                else if (isset($_SESSION["error_messageDeleteComment"])) {
                                    echo $_SESSION["error_messageDeleteComment"];
                                    unset($_SESSION["error_messageDeleteComment"]); // Clear the error message from session
                                }
                            ?>
                        </p>
                        <form class="comment-form" action="../controller/UserHomeController.php?action=handleCommentSubmission" method="post">
                            <input class="comment-input" type="text" name="comment_content" id="comment_content" rows="1" maxlength="50" required placeholder="Write a comment..."></input>
                            <input type="hidden" name="post_id" id="post_id" value="<?php echo $post['post_id']; ?>">
                            <input class="submit-button" type="submit" value="Comment">
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
                                <div class="comments-container">
                                    <div class="section1-comment">
                                        <span class="comment-username"><?php echo $comment['username']; ?></span>
                                        <a class="comment-settings-button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis"></i>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Edit comment</a>
                                                </li>
                                                <li>
                                                    <?php if ($comment['username'] == $sessionController->getUsername()) { ?>
                                                        <form action="../controller/UserHomeController.php?action=handleDeleteComment" method="post" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                                            <input type="hidden" name="comment_id" id="comment_id" value="<?php echo $comment['comment_id']; ?>">
                                                            <input type="hidden" name="comment_username" id="comment_username" value="<?php echo $comment['username']; ?>">
                                                            <button class="dropdown-item" type="submit">Delete comment</button>
                                                        </form>
                                                    <?php } else { ?>
                                                        <form action="../controller/UserHomeController.php?action=handleDeleteComment" method="post" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                                            <input type="hidden" name="comment_id" id="comment_id" value="<?php echo $comment['comment_id']; ?>">
                                                            <input type="hidden" name="comment_username" id="comment_username" value="<?php echo $comment['username']; ?>">
                                                            <button class="dropdown-item" type="submit" disabled >Delete comment</button>
                                                        </form>
                                                    <?php } ?>
                                                </li>
                                            </ul>
                                        </a>
                                    </div>
                                    <p class="comment-datetime"><?php echo $userHomeController->timeAgo($comment['comment_datetime']); ?></p>
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

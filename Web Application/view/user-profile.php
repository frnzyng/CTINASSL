<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSite - User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/user-main.css">
    <link rel="stylesheet" href="css/user-profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1f47064a19.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js/toggler.js"></script>
    
    <!-- Navigation Bar -->
    <div class="container px-0 fixed-top bg-white">
        <header>        
            <nav class="nav justify-content-center align-items-center mx-3">
                <div class="greetings-container">
                    <?php
                        include_once("../controller/SessionController.php");
                        $sessionController = new SessionController();

                        // Check if the account ID exists before displaying
                        $accountUsername = $sessionController->getUsername();

                        if ($accountUsername !== null) {
                            echo "<span class='greetings'> Hi " . $accountUsername . "! </span>";
                        } 
                        else {
                            echo "<span class='greetings'>Not logged in</span>";
                        }
                    ?>
                </div>
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
                <div class="logout-container">
                    <form action="../controller/UserAuthController.php?action=handleLogout" method="post">
                        <button class="logout-button" type="submit">Logout</button>
                    </form>
                </div>
            </nav>
        </header>
    </div>
 
    <div class="container px-0">
        <!-- Create Post -->
        <div class="row justify-content-center align-items-center mx-2">
            <div class="create-post-container" id="create-post-container">   
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
                        <a class="cancel-button" href="javascript:void(0);" onclick="Toggler.toggleCreatePost()">Cancel</a>
                        <input class="submit-button" type="submit" value="Post">
                    </div>
                </form>
            </div>
        </div>

        <!-- Displaying posts and comments -->
        <div class="row justify-content-center align-items-center mx-2">
            <?php 
                include_once("../controller/UserProfileController.php"); 
                $userProfileController = new UserProfileController();
            ?>
            
            <!-- Post Block -->
            <div class="post-block" id="post-block">
                <div class="block-heading">
                    <h4>User Profile</h4>
                    <a class="create-post-button" href="javascript:void(0);" onclick="Toggler.toggleCreatePost()">Create Post</a>
                </div>

                <?php
                    try {
                        // Get all posts
                        $posts = UserProfileController::handlePostRetrieval();
                    } 
                    catch (Exception $e) {
                        echo "Error retrieving posts: " . $e->getMessage();
                    }
                ?>

                <p class="status-message">
                    <?php
                        // Display any status messages
                        if (isset($_SESSION["success_message_submit_post"])) {
                            echo $_SESSION["success_message_submit_post"];
                            unset($_SESSION["success_message_submit_post"]);
                        }
                        else if (isset($_SESSION["error_message_submit_post"])) {
                            echo $_SESSION["error_message_submit_post"];
                            unset($_SESSION["error_message_submit_post"]);
                        }
                        else if (isset($_SESSION["success_message_edit_post"])) {
                            echo $_SESSION["success_message_edit_post"];
                            unset($_SESSION["success_message_edit_post"]);
                        }
                        else if (isset($_SESSION["error_message_edit_post"])) {
                            echo $_SESSION["error_message_edit_post"];
                            unset($_SESSION["error_message_edit_post"]);
                        }
                        else if (isset($_SESSION["success_message_delete_post"])) {
                            echo $_SESSION["success_message_delete_post"];
                            unset($_SESSION["success_message_delete_post"]);
                        }
                        else if (isset($_SESSION["error_message_delete_post"])) {
                            echo $_SESSION["error_message_delete_post"];
                            unset($_SESSION["error_message_delete_post"]);
                        }
                    ?>
                </p>

                <!-- Display all posts -->
                <?php foreach ($posts as $post): ?>
                    <!-- Post -->
                    <div class="post-container" id="post-container<?php echo $post['post_id']; ?>">
                        <div class="section1-post">
                            <h5><?php echo $post['post_topic']; ?></h5>
                            <a class="post-settings-button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis"></i>
                                <ul class="dropdown-menu">
                                    <li>
                                        <?php if ($post['username'] == $sessionController->getUsername()) { ?>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="Toggler.toggleEditPost(<?php echo $post['post_id']; ?>)">Edit post</a>
                                        <?php } else { ?>
                                            <a class="dropdown-item disabled">Edit post</a>
                                        <?php } ?>
                                    </li>
                                    <li>
                                        <?php if ($post['username'] == $sessionController->getUsername()) { ?>
                                            <form action="../controller/UserProfileController.php?action=handleDeletePost" method="post" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                <input type="hidden" name="post_id" id="post_id" value="<?php echo $post['post_id']; ?>">
                                                <button class="dropdown-item" type="submit">Delete post</button>
                                            </form>
                                        <?php } else { ?>
                                            <a class="dropdown-item disabled">Delete post</a>
                                        <?php } ?>
                                    </li>
                                </ul>
                            </a>
                        </div>

                        <div class="section2-post">
                            <p class="post-username">Posted by <?php echo $post['username'] . " - " . $userProfileController->timeAgo($post['post_datetime']); ?></p>
                            <p class="post-content"><?php echo $post['post_content']; ?></p>
                            <a class="view-comments-button" onclick="Toggler.toggleComments(<?php echo $post['post_id']; ?>)"><i class="fa-solid fa-message"></i></a>
                        </div>
                    </div>

                    <!-- Edit Post -->
                    <div class="edit-post-container" id="edit-post-container<?php echo $post['post_id']; ?>">   
                        <h4>Edit Post</h4>
                        <form class="post-form" id="edit-post-container" action="../controller/UserProfileController.php?action=handleEditPost" method="post">
                            <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                            <div class="topic-container">
                                <label for="post_topic">Topic</label>
                                <input class="edit-topic-input" type="text" name="new_post_topic" id="new_post_topic" maxlength="50" required value="<?php echo $post['post_topic']; ?>">
                            </div>  
                            <div class="content-container">
                                <label for="post_content">Content</label>
                                <textarea class="edit-content-input" name="new_post_content" id="new_post_content" rows="5" maxlength="250" required><?php echo $post['post_content']; ?></textarea>
                            </div>
                            <div class="button-container">
                                <a class="cancel-button" href="javascript:void(0);" onclick="Toggler.toggleEditPost(<?php echo $post['post_id']; ?>)">Cancel</a>
                                <input class="submit-button" type="submit" value="Save">
                            </div>
                        </form>
                    </div>

                    <!-- Comments Block -->
                    <div class="comments-block" id="comments-block<?php echo $post['post_id']; ?>">
                        <h5>Comments</h5>

                        <p class="status-message">
                            <?php
                                // Display any status messages
                                if (isset($_SESSION["success_message_submit_comment"])) {
                                    echo $_SESSION["success_message_submit_comment"];
                                    unset($_SESSION["success_message_submit_comment"]);
                                }
                                else if (isset($_SESSION["error_message_submit_comment"])) {
                                    echo $_SESSION["error_message_submit_comment"];
                                    unset($_SESSION["error_message_submit_comment"]);
                                }
                                else if (isset($_SESSION["success_message_edit_comment"])) {
                                    echo $_SESSION["success_message_edit_comment"];
                                    unset($_SESSION["success_message_edit_comment"]);
                                }
                                else if (isset($_SESSION["error_message_edit_comment"])) {
                                    echo $_SESSION["error_message_edit_comment"];
                                    unset($_SESSION["error_message_edit_comment"]);
                                }
                                else if (isset($_SESSION["success_message_delete_comment"])) {
                                    echo $_SESSION["success_message_delete_comment"];
                                    unset($_SESSION["success_message_delete_comment"]);
                                }
                                else if (isset($_SESSION["error_message_delete_comment"])) {
                                    echo $_SESSION["error_message_delete_comment"];
                                    unset($_SESSION["error_message_delete_comment"]);
                                }
                            ?>
                        </p>

                        <!-- Write a Comment  -->
                        <form class="comment-form" action="../controller/UserProfileController.php?action=handleCommentSubmission" method="post">
                            <input class="comment-input" type="text" name="comment_content" id="comment_content" rows="1" maxlength="50" required placeholder="Write a comment..."></input>
                            <input type="hidden" name="post_id" id="post_id" value="<?php echo $post['post_id']; ?>">
                            <input class="submit-button" type="submit" value="Comment">
                        </form>

                        <?php
                            try {
                                // Get comments for each post
                                $comments = UserProfileController::handleCommentRetrieval($post['post_id']);
                            } 
                            catch (Exception $e) {
                                echo "Error retrieving comments: " . $e->getMessage();
                            }
                        ?>

                        <!-- Display all comments -->
                        <?php if (!empty($comments)): ?>
                            <?php foreach ($comments as $comment): ?>
                                <!-- Comment -->
                                <div class="comment-container" id="comment-container<?php echo $comment['comment_id']; ?>">
                                    <div class="section1-comment">
                                        <span class="comment-username"><?php echo $comment['username']; ?></span>
                                        <a class="comment-settings-button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis"></i>
                                            <ul class="dropdown-menu">
                                            <li>
                                                <?php if ($comment['username'] == $sessionController->getUsername()) { ?>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="Toggler.toggleEditComment(<?php echo $comment['comment_id']; ?>)">Edit comment</a>
                                                <?php } else { ?>
                                                    <a class="dropdown-item disabled">Edit comment</a>
                                                <?php } ?>
                                            </li>
                                                <li>
                                                    <?php if ($comment['username'] == $sessionController->getUsername()) { ?>
                                                        <form action="../controller/UserProfileController.php?action=handleDeleteComment" method="post" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                                            <input type="hidden" name="comment_id" id="comment_id" value="<?php echo $comment['comment_id']; ?>">
                                                            <input type="hidden" name="comment_username" id="comment_username" value="<?php echo $comment['username']; ?>">
                                                            <button class="dropdown-item" type="submit">Delete comment</button>
                                                        </form>
                                                    <?php } else { ?>
                                                        <a class="dropdown-item disabled">Delete comment</a>
                                                    <?php } ?>
                                                </li>
                                            </ul>
                                        </a>
                                    </div>
                                    <p class="comment-datetime"><?php echo $userProfileController->timeAgo($comment['comment_datetime']); ?></p>
                                    <p class="comment-content"><?php echo $comment['comment_content']; ?></p>
                                </div>

                                <!-- Edit Comment -->
                                <div class="edit-comment-container" id="edit-comment-container<?php echo $comment['comment_id']; ?>">
                                    <span class="comment-username"><?php echo $comment['username']; ?></span>
                                    <p class="comment-datetime"><?php echo $userProfileController->timeAgo($comment['comment_datetime']); ?></p>
                                    <form class="edit-comment-form" action="../controller/UserProfileController.php?action=handleEditComment" method="post">
                                        <input class="edit-comment-input" type="text" name="new_comment_content" id="new_comment_content" rows="1" maxlength="50" required value="<?php echo $comment['comment_content']; ?>"></input>
                                        <input type="hidden" name="comment_id" id="comment_id" value="<?php echo $comment['comment_id']; ?>">
                                        <div class="button-container">
                                            <a class="cancel-button" href="javascript:void(0);" onclick="Toggler.toggleEditComment(<?php echo $comment['comment_id']; ?>)">Cancel</a>
                                            <input class="submit-button" type="submit" value="Save">
                                        </div>                                        
                                    </form>
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

</body>
</html>
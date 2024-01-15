<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSite - Post Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/admin-main.css">
    <link rel="stylesheet" href="css/admin-post-management.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1f47064a19.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js/admin-toggler.js"></script>
    <script src="js/user-post-chart.js"></script>

    <!-- Navigation Bar -->
    <div class="container px-0 fixed-top bg-white">
        <header>        
            <nav class="nav justify-content-center align-items-center mx-3">
                <ul class="nav justify-content-between">
                    <li class="nav-item">
                        <a href="admin-dashboard.php"><i class="fa-solid fa-house"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-account-management.php"><i class="fa-solid fa-image-portrait"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-post-management.php"><i class="fa-solid fa-copy"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-comment-management.php"><i class="fa-solid fa-message"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-settings.php"><i class="fa-solid fa-gear"></i></a>
                    </li>
                </ul>
            </nav>
        </header>
    </div>

    <div class="container px-0">
        <div class="row justify-content-center align-items-center mx-2">
            <div class="post-management-block">
                <h4>Post Management</h4>
                
                <!-- Chart -->
                <div class="chart-block">
                    <?php include_once('../controller/AdminPostManagementController.php'); ?>
                    <div class="chart-container">
                        <canvas id="postsChart" width="250" height="250"></canvas>
                    </div>
                    <h4> <?php echo implode(AdminPostManagementController::getCountPosts())?> Posts</h4>
                </div>

                <!-- Table -->
                <div class="table-block table-responsive">
                    <?php
                        include_once("../controller/AdminPostManagementController.php");
                        try {
                            // Get all posts
                            $posts = AdminPostManagementController::handlePostRetrieval();
                        } 
                        catch (Exception $e) {
                            echo "Error retrieving posts: " . $e->getMessage();
                        }
                    ?>
                    <p class="status-message">
                        <?php
                            session_start();
                            // Display any status messages
                            if (isset($_SESSION["success_message_edit_post"])) {
                                echo $_SESSION["success_message_edit_post"];
                                unset($_SESSION["success_message_edit_post"]); // Clear the error message from session
                            }
                            else if (isset($_SESSION["error_message_edit_post"])) {
                                echo $_SESSION["error_message_edit_post"];
                                unset($_SESSION["error_message_edit_post"]); // Clear the error message from session
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
                    <table class="table table-hover" id="table-posts">
                        <thead>
                            <th>Post ID</th>
                            <th>Account ID</th>
                            <th>Username</th>
                            <th>Post Topic</th>
                            <th>Post Content</th>
                            <th>Post DateTime</th>
                            <th>Action</th>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php foreach($posts as $post): ?>
                            <tr>
                                <td><?php echo $post['post_id']?></td>
                                <td><?php echo $post['account_id']?></td>
                                <td><?php echo $post['username']?></td>
                                <td><?php echo $post['post_topic']?></td>
                                <td><?php echo $post['post_content']?></td>
                                <td><?php echo $post['post_datetime']?></td>
                                <td>
                                    <a href="javascript:void(0);" onclick="Toggler.toggleEditPost(<?php echo $post['post_id']; ?>)"><i class="fa-solid fa-pencil"></i></a>
                                    <form class="delete-form" action="../controller/AdminPostManagementController.php?action=handleDeletePost" method="post" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        <input type="hidden" name="post_id" id="post_id" value="<?php echo $post['post_id']; ?>">
                                        <button class="delete-button" type="submit"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>    
                                </td>
                            </tr>
                            <!-- Edit Post -->
                            <div class="edit-post-block">
                                <div class="edit-post-container" id="edit-post-container<?php echo $post['post_id']; ?>">   
                                    <h4>Edit Post</h4>
                                    <form class="edit-post-form" id="edit-post-container" action="../controller/AdminPostManagementController.php?action=handleEditPost" method="post">
                                        <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                                        <div class="edit-topic-container">
                                            <label for="post_topic">Topic</label>
                                            <input class="edit-topic-input" type="text" name="new_post_topic" id="new_post_topic" maxlength="50" required value="<?php echo $post['post_topic']; ?>">
                                        </div>  
                                        <div class="edit-content-container">
                                            <label for="post_content">Content</label>
                                            <textarea class="edit-content-input" name="new_post_content" id="new_post_content" rows="5" maxlength="250" required><?php echo $post['post_content']; ?></textarea>
                                        </div>
                                        <div class="button-container">
                                            <a class="cancel-button" href="javascript:void(0);" onclick="Toggler.toggleEditPost(<?php echo $post['post_id']; ?>)">Cancel</a>
                                            <input class="submit-button" type="submit" value="Save">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
  
</body>
</html>
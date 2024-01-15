<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSite - Comment Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/admin-main.css">
    <link rel="stylesheet" href="css/admin-comment-management.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1f47064a19.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js/admin-toggler.js"></script>
    <script src="js/user-comment-chart.js"></script>

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
            <div class="comment-management-block">
                <h4>Comment Management</h4>
                
                <!-- Chart -->
                <div class="chart-block">
                    <?php include_once('../controller/AdminCommentManagementController.php'); ?>
                    <div class="chart-container">
                        <canvas id="commentsChart" width="250" height="250"></canvas>
                    </div>
                    <h4> <?php echo implode(AdminCommentManagementController::getCountComments())?> Comments</h4>
                </div>

                <!-- Table -->
                <div class="table-block table-responsive">
                    <?php
                        include_once("../controller/AdminCommentManagementController.php");
                        try {
                            // Get all comments
                            $comments = AdminCommentManagementController::handleCommentRetrieval();
                        } 
                        catch (Exception $e) {
                            echo "Error retrieving comments: " . $e->getMessage();
                        }
                    ?>
                    <p class="status-message">
                        <?php
                            session_start();
                            // Display any status messages
                            if (isset($_SESSION["success_message_edit_comment"])) {
                                echo $_SESSION["success_message_edit_comment"];
                                unset($_SESSION["success_message_edit_comment"]); // Clear the error message from session
                            }
                            else if (isset($_SESSION["error_message_edit_comment"])) {
                                echo $_SESSION["error_message_edit_comment"];
                                unset($_SESSION["error_message_edit_comment"]); // Clear the error message from session
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
                    <table class="table table-hover" id="table-comments">
                        <thead>
                            <th>Comment ID</th>
                            <th>Post ID</th>
                            <th>Account ID</th>
                            <th>Username</th>                            
                            <th>Comment Content</th>
                            <th>Comment DateTime</th>
                            <th>Action</th>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php foreach($comments as $comment): ?>
                            <tr>
                                <td><?php echo $comment['comment_id']?></td>
                                <td><?php echo $comment['post_id']?></td>
                                <td><?php echo $comment['account_id']?></td>
                                <td><?php echo $comment['username']?></td>
                                <td><?php echo $comment['comment_content']?></td>
                                <td><?php echo $comment['comment_datetime']?></td>
                                <td>
                                    <a href="javascript:void(0);" onclick="Toggler.toggleEditComment(<?php echo $comment['comment_id']; ?>)"><i class="fa-solid fa-pencil"></i></a>
                                    <form class="delete-form" action="../controller/AdminCommentManagementController.php?action=handleDeleteComment" method="post" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        <input type="hidden" name="comment_id" id="comment_id" value="<?php echo $comment['comment_id']; ?>">
                                        <button class="delete-button" type="submit"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>    
                                </td>
                            </tr>
                            <!-- Edit Comment -->
                            <div class="edit-comment-block">
                                <div class="edit-comment-container" id="edit-comment-container<?php echo $comment['comment_id']; ?>">   
                                    <h4>Edit Comment</h4>
                                    <form class="edit-comment-form" id="edit-comment-container" action="../controller/AdminCommentManagementController.php?action=handleEditComment" method="post">
                                        <input type="hidden" name="comment_id" value="<?php echo $comment['comment_id']; ?>">
                                        <div class="edit-content-container">
                                            <label for="comment_content">Content</label>
                                            <textarea class="edit-content-input" name="new_comment_content" id="new_comment_content" rows="5" maxlength="250" required><?php echo $comment['comment_content']; ?></textarea>
                                        </div>
                                        <div class="button-container">
                                            <a class="cancel-button" href="javascript:void(0);" onclick="Toggler.toggleEditComment(<?php echo $comment['comment_id']; ?>)">Cancel</a>
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
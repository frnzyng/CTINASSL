<?php

$action = isset($_GET['action']) ? $_GET['action'] : '';
$controller = new AdminPostManagementController();

if ($action === 'getCountPosts') {
    echo json_encode($controller->getCountPosts());
}
else if ($action === 'handleEditPost') {
    $controller->handleEditPost();
}
else if ($action === 'handleDeletePost') {
    $controller->handleDeletePost();
}

class AdminPostManagementController {

    public static function getCountPosts() {
        try {
            include_once("../model/UserPostModel.php");

            $count = UserPostModel::countPosts();

            return $count;
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }
    
    public static function handlePostRetrieval() {
        try {
            include_once("../model/UserPostModel.php");
            $retrievedPosts = UserPostModel::getPost();

            return $retrievedPosts;
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }

    public function handleEditPost() {
        try {
            include_once("../controller/AdminSessionController.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get session
                $sessionController = new AdminSessionController();
                $account_id = $sessionController->getAdminAccountId();
                $username = $sessionController->getAdminUsername();
                
                // Validate and sanitize form inputs  
                $post_id = trim($_POST["post_id"]);
                $new_post_topic = trim($_POST["new_post_topic"]);
                $new_post_content = trim($_POST["new_post_content"]);

                if ($account_id === null && $username === null) {
                    $_SESSION["error_message_edit_post"] = "Session Expired";
                    header('Location:../view/admin-post-management.php');             
                } 
                else if ($post_id === "" && $post_id === null) {
                    $_SESSION["error_message_edit_post"] = "Post not found";
                    header('Location:../view/admin-post-management.php');
                }
                else if ($new_post_topic === "" && $new_post_content === "") {
                    $_SESSION["error_message_edit_post"] = "Fields should not be blank";
                    header('Location:../view/admin-post-management.php');
                }
                else{
                    include_once("../model/UserPostModel.php");
                    $editedPost = UserPostModel::editPost($post_id, $new_post_topic, $new_post_content);

                    if ($editedPost === true) {
                        $_SESSION["success_message_edit_post"] = "Posted is updated successfully!";
                        header('Location:../view/admin-post-management.php');
                    } 
                    else if ($editedPost === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message_edit_post"] = "Error updating post";
                        header('Location:../view/admin-post-management.php');
                    }
                    // Don't put else block here
                }
            }
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }

    public function handleDeletePost() {
        try {
            include_once("../controller/AdminSessionController.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get session
                $sessionController = new AdminSessionController();
                $admin_post_id = $sessionController->getAdminAccountId();
                $admin_username = $sessionController->getAdminUsername();
                
                // Validate and sanitize form inputs  
                $post_id = trim($_POST["post_id"]);

                if ($admin_post_id === null && $admin_username === null) {
                    $_SESSION["error_message_delete_post"] = "Session Expired";
                    header('Location:../view/admin-post-management.php');             
                } 
                else if ($post_id === "" && $post_id === null) {
                    $_SESSION["error_message_delete_post"] = "Post not found";
                    header('Location:../view/admin-post-management.php');
                }
                else{
                    include_once("../model/UserPostModel.php");
                    $deletedPost = UserPostModel::deletePost($post_id);

                    if ($deletedPost === true) {
                        $_SESSION["success_message_delete_post"] = "Post is deleted successfully!";
                        header('Location:../view/admin-post-management.php');
                    } 
                    else if ($deletedPost === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message_delete_post"] = "Error deleting post";
                        header('Location:../view/admin-post-management.php');
                    }
                    // Don't put else block here
                }
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>
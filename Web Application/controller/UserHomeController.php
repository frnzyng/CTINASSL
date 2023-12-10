<?php

// Check for the action parameter in the URL
$action = isset($_GET['action']) ? $_GET['action'] : '';
$controller = new UserHomeController();

if ($action === 'handlePostSubmission') {
    $controller->handlePostSubmission();
}
class UserHomeController {

    /*public function showForm() {
        // Load the form view
        include('views/post_form.php');
    } */

    
    public function handlePostSubmission() {
        include("../controller/SessionController.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get session
            $sessionController = new SessionController();

            // Validate and sanitize form inputs
            $account_id = $sessionController->getAccountId();
            $username = $sessionController->getUsername();
            $post_topic = trim($_POST["post_topic"]);
            $post_content = trim($_POST["post_content"]);

            // You may want to perform additional validation here

            // Example: Insert data into the tblPosts table using the model
            if ($account_id != "" && $username != "" && $post_topic != "" && $post_content != "") {
                include("../model/UserPostModel.php");
                $success = UserPostModel::submitPost($account_id, $username, $post_topic, $post_content);
            }
            else{
                $_SESSION["error_message"] = "Fields should not be null";
            }

            // Load the appropriate view based on success or failure
            if ($success) {
                header('Location:../view/user-home.php');
                $_SESSION["error_message"] = "Post submitted successfully!";
                return $success;
            } else {
                header('Location:../view/user-home.php');
                $_SESSION["error_message"] = "Error submitting post";
            }
        }
    }

    public static function handlePostRetrieval() {
        try {
            include("../model/UserPostModel.php");
            $posts = UserPostModel::getPost();

            return $posts;
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }
}
?>

<?php
include("../model/UserPostModel.php");
include("../controller/SessionController.php");

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
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get session
            $sessionController = new SessionController();
            $currentAccountId = $sessionController->getAccountId();

            // Validate and sanitize form inputs
            $account_id = $currentAccountId;
            $post_topic = trim($_POST["post_topic"]);
            $post_content = trim($_POST["post_content"]);

            // You may want to perform additional validation here

            // Example: Insert data into the tblPosts table using the model
            if ($account_id != "" && $post_topic != "" && $post_content != "") {

                $model = new UserPostModel();
                $success = $model->submitPost($account_id, $post_topic, $post_content);
            }
            else{
                $_SESSION["error_message"] = "Fields should not be null";
            }

            // Load the appropriate view based on success or failure
            if ($success) {
                include('../view/user-home.php');
                $_SESSION["error_message"] = "Post submitted successfully!";
                return $success;
            } else {
                include('../view/user-home.php');
                $_SESSION["error_message"] = "Error submitting post";
            }
        }
    }

    public function handlePostRetrieval() {
        try {
            $model = new UserPostModel();
            $posts = $model->getPost();

            return $posts;
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }
}
?>

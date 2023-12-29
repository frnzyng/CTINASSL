<?php

$action = isset($_GET['action']) ? $_GET['action'] : '';
$controller = new UserRegistrationController();

if ($action === 'handleUserRegistration') {
    $controller->handleUserRegistration();
}
    class UserRegistrationController {

        public function handleUserRegistration() {
            // Process form submission
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = trim($_POST["username"]);
                $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
                $email = trim($_POST["email"]);
            
                if ($username != "" && $password != "" && $email != "") {
                    include_once("../model/UserAccountModel.php");
                    $success = UserAccountModel::registerUser($username, $password, $email);
                }
                else{
                    session_start();
                    $_SESSION["status_message"] = "Fields should not be null";
                    exit();
                }
    
                // Load the appropriate view based on success or failure
                if ($success) {
                    session_start();
                    header('Location:../view/user-registration.php');
                    $_SESSION["status_message"] = "User registered successfully!";
                    exit();
                } else {
                    session_start();
                    header('Location:../view/user-registration.php');
                    $_SESSION["status_message"] = "Error on registering user";
                    exit();
                }
            }
        }
    }
?>
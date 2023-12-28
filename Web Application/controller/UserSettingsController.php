<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Check for the action parameter in the URL
$action = isset($_GET['action']) ? $_GET['action'] : '';
$controller = new UserSettingsController();

if ($action === 'handleChangeUsername') {
    $controller->handleChangeUsername();
}
else if ($action === 'handleChangeEmail') {
    $controller->handleChangeEmail();
}
else if ($action === 'handleChangePassword') {
    $controller->handleChangePassword();
}

class UserSettingsController {

    public function handleChangeUsername() {
        try {
            include_once("../controller/SessionController.php");
    
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get session
                $sessionController = new SessionController();
    
                // Validate and sanitize form inputs
                $account_id = $sessionController->getAccountId();
                $new_username = trim($_POST["new_username"]);
                $password = trim($_POST["password"]);
    
                if ($account_id != "" && $new_username != "" && $password != "") {
                    include_once("../model/UserAccountModel.php");
                    $success = UserAccountModel::updateUsername($account_id, $new_username, $password);


                } else {
                    $_SESSION["error_message"] = "Session Expired";
                    header('Location:../view/user-chusername.php');
                }
    
                // Load the appropriate view based on success or failure
                if ($success === true) {
                    header('Location:../view/user-chusername.php');
                    $_SESSION["success_message"] = "Changes are saved successfully!";
                } 
                else if ($success === false) {
                    // If an exception occurred in the model, store the error in the session
                    $_SESSION["error_message"] = "Error saving changes";
                    header('Location:../view/user-chusername.php');
                }
                else if ($success === "Password is incorrect") {
                    $_SESSION["error_message"] = "Password is incorrect";
                    header('Location:../view/user-chusername.php');
                }
                else if ($success === "Username already exists") {
                    $_SESSION["error_message"] = "Username already exists";
                    header('Location:../view/user-chusername.php');
                }
                // Don't put else block here

            }
        } 
        catch (Exception $e) {
            // If an exception occurs, store the error in the session
            $_SESSION["error_message"] = $e->getMessage();
            header('Location:../view/user-chusername.php');
        }
    }
    

    public function handleChangeEmail() {
        try {
            include_once("../controller/SessionController.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get session
                $sessionController = new SessionController();

                // Validate and sanitize form inputs
                $account_id = $sessionController->getAccountId();
                $new_email = trim($_POST["new_email"]);
                $password = trim($_POST["password"]);

                if ($account_id != "" && $new_email != "" && $password != "") {
                    include_once("../model/UserAccountModel.php");
                    $success = UserAccountModel::updateUserEmail($account_id, $new_email, $password);
                }
                else{
                    $_SESSION["error_message"] = "Fields should not be null";
                }

                // Load the appropriate view based on success or failure
                if ($success) {
                    header('Location:../view/user-chemail.php');
                    $_SESSION["error_message"] = "Changes are saved successfully!";
                    return $success;
                } else {
                    header('Location:../view/user-chemail.php');
                    $_SESSION["error_message"] = "Error saving changes";
                }
                header('Location:../view/user-chemail.php');
            }         
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function handleChangePassword() {
        try {
            include_once("../controller/SessionController.php");
    
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get session
                $sessionController = new SessionController();
    
                // Validate and sanitize form inputs
                $account_id = $sessionController->getAccountId();
                $current_password = password_hash($_POST["current_password"], PASSWORD_BCRYPT);
                $new_password1 = trim($_POST["new_password1"]);
                $new_password2 = trim($_POST["new_password2"]);
    
                if ($account_id === "") {
                    $_SESSION["error_message"] = "Session Expired";
                    header('Location:../view/user-chpassword.php');             
                } 
                else if ($current_password === "" && $new_password1 === "" && $new_password2 === "") {
                    $_SESSION["error_message"] = "Fields should not be blank";
                    header('Location:../view/user-chpassword.php');
                }
                else if ($current_password === ($new_password1 === $new_password2)) {
                    $_SESSION["error_message"] = "Current and new password should not be the same";
                    header('Location:../view/user-chpassword.php');
                }
                else if ($new_password1 !== $new_password2) {
                    $_SESSION["error_message"] = "Password does not match";
                    header('Location:../view/user-chpassword.php');
                }
                else {
                    include_once("../model/UserAccountModel.php");
                    $success = UserAccountModel::updateAccountPassword($account_id, $current_password, $new_password1);
                }
    
                // Load the appropriate view based on success or failure
                if ($success === true) {
                    $_SESSION["success_message"] = "Changes are saved successfully!";
                    header('Location:../view/user-chpassword.php');
                } 
                else if ($success === false) {
                    // If an exception occurred in the model, store the error in the session
                    $_SESSION["error_message"] = "Error saving changes";
                    header('Location:../view/user-chpassword.php');
                }
                // Don't put else block here

            }
        } 
        catch (Exception $e) {
            // If an exception occurs, store the error in the session
            $_SESSION["error_message"] = $e->getMessage();
            header('Location:../view/user-chpassword.php');
        }
    }

}
?>
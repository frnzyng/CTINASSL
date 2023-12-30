<?php

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
                $account_id = $sessionController->getAccountId();
                $current_username = $sessionController->getUsername();

                // Validate and sanitize form inputs
                $new_username = trim($_POST["new_username"]);
                $password = $_POST["password"];

                if ($account_id === null) {
                    $_SESSION["error_message"] = "Session Expired";
                    header('Location:../view/user-chusername.php');             
                } 
                else if ($new_username === "" && $password === null) {
                    $_SESSION["error_message"] = "Fields should not be blank";
                    header('Location:../view/user-chusername.php');
                }
                else if ($current_username === $new_username) {
                    $_SESSION["error_message"] = "Current username should not be the same as your new username";
                    header('Location:../view/user-chusername.php');
                }
                else {
                    include_once("../model/UserAccountModel.php");
                    $updatedAccount = UserAccountModel::updateAccountUsername($account_id, $new_username, $password);

                    if ($updatedAccount === true) {
                        $_SESSION["success_message"] = "Changes are saved successfully!";
                        header('Location:../view/user-chusername.php');
                    } 
                    else if ($updatedAccount === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message"] = "Error saving changes";
                        header('Location:../view/user-chusername.php');
                    }
                    else if ($updatedAccount === "Password is incorrect") {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message"] = "Password is incorrect";
                        header('Location:../view/user-chusername.php');
                    }
                    else if ($updatedAccount === "Username already exists") {
                        $_SESSION["error_message"] = "Username already exists";
                        header('Location:../view/user-chusername.php');
                    }
                    // Don't put else block here
                }
            }
        } 
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function handleChangeEmail() {
        try {
            include_once("../controller/SessionController.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get session
                $sessionController = new SessionController();
                $account_id = $sessionController->getAccountId();

                // Validate and sanitize form inputs               
                $new_email = trim($_POST["new_email"]);
                $password = $_POST["password"];

                if ($account_id === null) {
                    $_SESSION["error_message"] = "Session Expired";
                    header('Location:../view/user-chemail.php');             
                } 
                else if ($new_email === "" && $password === null) {
                    $_SESSION["error_message"] = "Fields should not be blank";
                    header('Location:../view/user-chemail.php');
                }
                else {
                    include_once("../model/UserAccountModel.php");
                    $updatedAccount = UserAccountModel::updateAccountEmail($account_id, $new_email, $password);

                    if ($updatedAccount === true) {
                        $_SESSION["success_message"] = "Changes are saved successfully!";
                        header('Location:../view/user-chemail.php');
                    } 
                    else if ($updatedAccount === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message"] = "Error saving changes";
                        header('Location:../view/user-chemail.php');
                    }
                    else if ($updatedAccount === "Password is incorrect") {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message"] = "Password is incorrect";
                        header('Location:../view/user-chemail.php');
                    }
                    else if ($updatedAccount === "Current and new email should not be the same") {
                        $_SESSION["error_message"] = "Current and new email should not be the same";
                        header('Location:../view/user-chemail.php');
                    }
                    else if ($updatedAccount === "Email already exists") {
                        $_SESSION["error_message"] = "Email already exists";
                        header('Location:../view/user-chemail.php');
                    }
                    // Don't put else block here
                }
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
                $account_id = $sessionController->getAccountId();    

                // Validate and sanitize form inputs
                $current_password = $_POST["current_password"];
                $new_password = $_POST["new_password"];
                $retyped_password = $_POST["retyped_password"];
    
                if ($account_id === null) {
                    $_SESSION["error_message"] = "Session Expired";
                    header('Location:../view/user-chpassword.php');             
                } 
                else if ($current_password === null && $new_password === null && $retyped_password === null) {
                    $_SESSION["error_message"] = "Fields should not be blank";
                    header('Location:../view/user-chpassword.php');
                }
                else if ($current_password === $new_password && $current_password === $retyped_password) {
                    $_SESSION["error_message"] = "Current and new password should not be the same";
                    header('Location:../view/user-chpassword.php');
                }
                else if ($new_password !== $retyped_password) {
                    $_SESSION["error_message"] = "Password does not match";
                    header('Location:../view/user-chpassword.php');
                }
                else {
                    include_once("../model/UserAccountModel.php");
                    $updatedAccount = UserAccountModel::updateAccountPassword($account_id, $current_password, $new_password);

                    if ($updatedAccount === true) {
                        $_SESSION["success_message"] = "Changes are saved successfully!";
                        header('Location:../view/user-chpassword.php');
                    } 
                    else if ($updatedAccount === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message"] = "Error saving changes";
                        header('Location:../view/user-chpassword.php');
                    }
                    else if ($updatedAccount === "Password is incorrect") {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message"] = "Password is incorrect";
                        header('Location:../view/user-chpassword.php');
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
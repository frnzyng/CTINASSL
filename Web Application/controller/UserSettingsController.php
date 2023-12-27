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
                }
                else{
                    $_SESSION["error_message"] = "Fields should not be null";
                }

                // Load the appropriate view based on success or failure
                if ($success) {
                    header('Location:../view/user-chusername.php');
                    $_SESSION["error_message"] = "Changes are saved successfully!";
                    return $success;
                } else {
                    header('Location:../view/user-chusername.php');
                    $_SESSION["error_message"] = "Error saving changes";
                }
                header('Location:../view/user-chusername.php');
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

}
?>
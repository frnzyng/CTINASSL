<?php

$action = isset($_GET['action']) ? $_GET['action'] : '';
$controller = new AdminAccountManagementController();

if ($action === 'getCountAccounts') {
    echo json_encode($controller->getCountAccounts());
}
else if ($action === 'handleEditAccount') {
    $controller->handleEditAccount();
}
else if ($action === 'handleDeleteAccount') {
    $controller->handleDeleteAccount();
}

class AdminAccountManagementController {

    public static function getCountAccounts() {
        try {
            include_once("../model/UserAccountModel.php");

            $count = UserAccountModel::countAccounts();

            return $count;
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }
    
    public static function handleAccountRetrieval() {
        try {
            include_once("../model/UserAccountModel.php");
            $retrievedAccounts = UserAccountModel::getAccounts();

            return $retrievedAccounts;
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function handleEditAccount() {
        try {
            include_once("../controller/AdminSessionController.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get session
                $sessionController = new AdminSessionController();
                $admin_account_id = $sessionController->getAdminAccountId();
                $admin_username = $sessionController->getAdminUsername();
                
                // Validate and sanitize form inputs  
                $account_id = trim($_POST["account_id"]);
                $new_username = trim($_POST["new_username"]);
                $new_password = $_POST["new_password"];
                $new_email = trim($_POST["new_email"]);
                $action = "Edited user's account information";
                $ip_address = $_SERVER['REMOTE_ADDR'];


                if ($admin_account_id === null && $admin_username === null) {
                    $_SESSION["error_message_edit_account"] = "Session Expired";
                    header('Location:../view/admin-account-management.php');             
                } 
                else if ($account_id === "" && $account_id === null) {
                    $_SESSION["error_message_edit_account"] = "Account not found";
                    header('Location:../view/admin-account-management.php');
                }
                else{
                    include_once("../model/UserAccountModel.php");
                    $updatedAccount = UserAccountModel::updateAccount($account_id, $new_username, $new_password, $new_email);

                    if ($updatedAccount === true) {
                        include_once("../model/AdminAccountModel.php");
                        $recordedLog = AdminAccountModel::recordActivityLog($admin_account_id, $action, $ip_address);

                        if ($recordedLog) {
                            $_SESSION["success_message_edit_account"] = "Account is updated successfully!";
                            header('Location:../view/admin-account-management.php');
                        }
                     } 
                    else if ($updatedAccount === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message_edit_account"] = "Error updating account";
                        header('Location:../view/admin-account-management.php');
                    }
                    else if ($updatedAccount === "Username already exists") {
                        $_SESSION["error_message_edit_account"] = "Username already exists";
                        header('Location:../view/admin-account-management.php');
                    }
                    else if ($updatedAccount === "Email already exists") {
                        $_SESSION["error_message_edit_account"] = "Email already exists";
                        header('Location:../view/admin-account-management.php');
                    }
                    // Don't put else block here
                }
            }            
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function handleDeleteAccount() {
        try {
            include_once("../controller/AdminSessionController.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get session
                $sessionController = new AdminSessionController();
                $admin_account_id = $sessionController->getAdminAccountId();
                $admin_username = $sessionController->getAdminUsername();
                
                // Validate and sanitize form inputs  
                $account_id = trim($_POST["account_id"]);
                $action = "Deleted user account";
                $ip_address = $_SERVER['REMOTE_ADDR'];

                if ($admin_account_id === null && $admin_username === null) {
                    $_SESSION["error_message_delete_account"] = "Session Expired";
                    header('Location:../view/admin-account-management.php');             
                } 
                else if ($account_id === "" && $account_id === null) {
                    $_SESSION["error_message_delete_account"] = "Account not found";
                    header('Location:../view/admin-account-management.php');
                }
                else{
                    include_once("../model/UserAccountModel.php");
                    $deletedAccount = UserAccountModel::deleteAccount($account_id);

                    if ($deletedAccount === true) {
                        include_once("../model/AdminAccountModel.php");
                        $recordedLog = AdminAccountModel::recordActivityLog($admin_account_id, $action, $ip_address);

                        if ($recordedLog) {
                            $_SESSION["success_message_delete_account"] = "Account is deleted successfully!";
                            header('Location:../view/admin-account-management.php');
                        }
                    } 
                    else if ($deletedAccount === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message_delete_account"] = "Error deleting account";
                        header('Location:../view/admin-account-management.php');
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
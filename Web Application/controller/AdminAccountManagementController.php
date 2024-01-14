<?php

$action = isset($_GET['action']) ? $_GET['action'] : '';
$controller = new AdminAccountManagementController();

if ($action === 'handleEditAccount') {
    $controller->handleEditAccount();
}
else if ($action === 'handleDeleteAccount') {
    $controller->handleDeleteAccount();
}

class AdminAccountManagementController {
    
    public static function handleAccounRetrieval() {
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
                        $_SESSION["success_message_delete_account"] = "Account is deleted successfully!";
                        header('Location:../view/admin-account-management.php');
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
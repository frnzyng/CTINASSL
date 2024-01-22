<?php
include_once("../model/AdminAuthModel.php");
include_once("../controller/AdminSessionController.php");

// Connect to database
$db = new PDO("mysql:host=localhost;dbname=BlogSite", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$model = new AdminAuthModel($db); // The database connection will be injected later

// Check for the action parameter in the URL
$action = isset($_GET['action']) ? $_GET['action'] : '';
$controller = new AdminAuthController($model);

if ($action == 'handleLogin') {
    $controller->handleLogin();
}
else if ($action == 'handleLogout') {
    $controller->handleLogout();
}

class AdminAuthController {
    private $model;

    public function __construct(AdminAuthModel $model) {
        $this->model = $model;
    }

    public function handleLogin() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validate and sanitize form inputs 
            $username = trim($_POST["username"]);
            $password = $_POST["password"];
            $action = "Login";
            $ip_address = $_SERVER['REMOTE_ADDR'];

            // Authenticate admin using the injected model
            $authenticatedAdmin = $this->model->authenticateAdmin($username, $password);

            if ($authenticatedAdmin) {
                // Start a session and store admin ID
                $sessionController = new AdminSessionController();
                $sessionController->startSession($authenticatedAdmin["account_id"], $authenticatedAdmin["username"]);

                $admin_account_id = $sessionController->getAdminAccountId();
                $recordedLog = $this->model->recordAdminLog($admin_account_id, $action, $ip_address);
                
                // Redirect to home dashboard after authentication
                if ($recordedLog) {
                    header("Location: ../view/admin-dashboard.php");
                    exit(); 
                }
                
            } 
            else {
                session_start();
                $_SESSION["error_message_login"] = "Invalid username or password";

                // Redirect back to the login page
                header("Location: ../view/admin-login.php");
                exit();
            }
        }
    }

    public function handleLogout() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sessionController = new AdminSessionController();

            // Validate and sanitize form inputs  
            $admin_account_id = $sessionController->getAdminAccountId();
            $action = "Logout";
            $ip_address = $_SERVER['REMOTE_ADDR'];

            $recordedLog = $this->model->recordAdminLog($admin_account_id, $action, $ip_address);

            if ($recordedLog) {
                $sessionController = new AdminSessionController();
                $sessionController->endSession();

                header("Location: ../view/admin-login.php");
                exit();
            }
        }
    }
}
?>
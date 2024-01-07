<?php
include_once("../model/UserAuthModel.php");
include_once("../controller/SessionController.php");

// Connect to database
$db = new PDO("mysql:host=localhost;dbname=BlogSite", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$model = new UserAuthModel($db); // The database connection will be injected later

// Check for the action parameter in the URL
$action = isset($_GET['action']) ? $_GET['action'] : '';
$controller = new UserAuthController($model);

if ($action == 'handleLogin') {
    $controller->handleLogin();
}
else if ($action == 'handleLogout') {
    $controller->handleLogout();
}

class UserAuthController {
    private $model;

    public function __construct(UserAuthModel $model) {
        $this->model = $model;
    }

    public function handleLogin() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validate and sanitize form inputs  
            $username = trim($_POST["username"]);
            $password = $_POST["password"];

            // Authenticate user using the injected model
            $authenticatedUser = $this->model->authenticateUser($username, $password);

            if ($authenticatedUser) {
                // Start a session and store user ID
                $sessionController = new SessionController();
                $sessionController->startSession($authenticatedUser["account_id"], $authenticatedUser["username"]);

                // Redirect to home page after authentication
                header("Location: ../view/user-home.php");
                exit();
            } 
            else {
                session_start();
                $_SESSION["error_message_login"] = "Invalid username or password";

                // Redirect back to the login page
                header("Location: ../view/user-login.php");
                exit();
            }
        }
    }

    public function handleLogout() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sessionController = new SessionController();

            $sessionController->endSession();

            header("Location: ../view/user-login.php");
            exit();
        }
    }
}
?>
<?php
// Don't move
include("../model/UserAuthModel.php");
include("../controller/SessionController.php");
class UserAuthController {
    private $model;

    public function __construct(UserAuthModel $model) {
        $this->model = $model;
    }

    public function handleLogin() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Authenticate user using the injected model
            $authenticatedUser = $this->model->authenticateUser($username, $password);

            if ($authenticatedUser) {
                // Start a session and store user ID
                $sessionController = new SessionController();
                $sessionController->startSession($authenticatedUser["account_id"], $authenticatedUser["username"]);

                // Redirect to home dashboard
                header("Location: ../view/user-home.php");
                exit();
            } else {
                session_start();
                $_SESSION["error_message"] = "Invalid username or password";

                // Redirect back to the login page
                header("Location: ../view/user-login.php");
                exit();
            }
        }
    }
}

$db = new PDO("mysql:host=localhost;dbname=BlogSite", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$model = new UserAuthModel($db); // The database connection will be injected later
$controller = new UserAuthController($model);
$controller->handleLogin();
?>
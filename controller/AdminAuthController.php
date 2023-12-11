<?php
// Don't move; put session here too
include("../model/AdminAuthModel.php");
class AdminAuthController {
    private $model;

    public function __construct(AdminAuthModel $model) {
        $this->model = $model;
    }

    public function handleLogin() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Authenticate user using the injected model
            $authenticatedAdmin = $this->model->authenticateAdmin($username, $password);

            if ($authenticatedAdmin) {
                // Start a session and store user ID
                session_start();
                $_SESSION["user_id"] = $authenticatedAdmin["account_id"];

                // Redirect to home dashboard
                header("Location: ../view/admin-dashboard.php");
                exit();
            } else {
                session_start();
                $_SESSION["error_message"] = "Invalid username or password";

                // Redirect back to the login page
                header("Location: ../view/admin-login.php");
                exit();
            }
        }

        // Load login view (form)
        include('../view/admin-login.php');
    }
}

$db = new PDO("mysql:host=localhost;dbname=BlogSite", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$model = new AdminAuthModel($db); // The database connection will be injected later
$controller = new AdminAuthController($model);
$controller->handleLogin();
?>
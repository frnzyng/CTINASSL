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
            $action = "Login";
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $response = $_POST['g-recaptcha-response'];
            $secret = '6Lc4yG4pAAAAAMZ6bPgjF7XwHb8t2k6Y2Oj25IFU';
            $remoteip = $_SERVER['REMOTE_ADDR'];
            

            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = array(
                'secret' => $secret,
                'response' => $response,
                'remoteip' => $remoteip
            );

            $options = array(
                'http' => array (
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );

            $context  = stream_context_create($options);
            $verify = file_get_contents($url, false, $context);
            $captcha_success = json_decode($verify);

            // Authenticate user using the injected model and record the user log
            $authenticatedUser = $this->model->authenticateUser($username, $password);

            if ($captcha_success->success == true) {
                if ($authenticatedUser) {
                // Start a session and store user ID
                $sessionController = new SessionController();
                $sessionController->startSession($authenticatedUser["account_id"], $authenticatedUser["username"]);

                $account_id = $sessionController->getAccountId();
                $recordedLog = $this->model->recordUserLog($account_id, $action, $ip_address);

                    // Redirect to home page after authentication and record of log
                    if ($recordedLog) {
                        header("Location: ../view/user-home.php");
                        exit();
                    }
                } 
                else {
                    session_start();
                    $_SESSION["error_message_login"] = "Invalid username or password";

                    // Redirect back to the login page
                    header("Location: ../view/user-login.php");
                    exit();
                }
            }
            else if ($captcha_success->success == false) {
                session_start();
                    $_SESSION["error_message_login"] = "Please complete reCAPTCHA";

                    // Redirect back to the login page
                    header("Location: ../view/user-login.php");
                    exit();
            }
        }
    }

    public function handleLogout() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sessionController = new SessionController();

            // Validate and sanitize form inputs  
            $account_id = $sessionController->getAccountId();
            $action = "Logout";
            $ip_address = $_SERVER['REMOTE_ADDR'];

            $recordedLog = $this->model->recordUserLog($account_id, $action, $ip_address);

            if ($recordedLog) {
                $sessionController = new SessionController();
                $sessionController->endSession();
    
                header("Location: ../view/user-login.php");
                exit();
            }
        }
    }
}
?>
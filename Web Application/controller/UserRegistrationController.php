<?php

$action = isset($_GET['action']) ? $_GET['action'] : '';
$controller = new UserRegistrationController();

if ($action === 'handleUserRegistration') {
    $controller->handleUserRegistration();
}
class UserRegistrationController {

    public function handleUserRegistration() {
        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                session_start(); //Need to start session to display the status/alert message

                $username = trim($_POST["username"]);
                $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
                $email = trim($_POST["email"]);
                
            
                if ($username === "" && $password === "" && $email === "") {
                    $_SESSION["error_message"] = "Fields should not be blank";
                    header('Location:../view/user-registration.php');
                }
                else {
                    include_once("../model/UserAccountModel.php");
                    $registeredUser = UserAccountModel::registerUser($username, $password, $email);
                    

                    if ($registeredUser === true) {
                        $_SESSION["success_messageRegister"] = "User registered successfully!";
                        header('Location:../view/user-registration.php');
                    } 
                    else if ($registeredUser === false) {
                        $_SESSION["error_messageRegister"] = "Error on registering user";
                        header('Location:../view/user-registration.php');
                    }
                    else if ($registeredUser === "Username already exists") {
                        $_SESSION["error_messageRegister"] = "Username already exists";
                        header('Location:../view/user-registration.php');
                    }
                    else if ($registeredUser === "Email already exists") {
                        $_SESSION["error_messageRegister"] = "Email already exists";
                        header('Location:../view/user-registration.php');
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
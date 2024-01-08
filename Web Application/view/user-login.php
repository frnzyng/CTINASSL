<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSite - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/user-main.css">
    <link rel="stylesheet" href="css/user-login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <!-- Navigation Bar -->
    <div class="container px-0">
        <header>        
            <nav>
                <h4><a href="user-login.php">BLOGSITE</a></h4>
            </nav>
        </header>
    </div>
 
    <!-- Login -->
    <div class="container">
        <div class="row justify-content-center align-items-center mx-2">
            <div class = "login-container">
                <h3>Login</h3>

                <p class="status-message">
                    <?php
                        session_start();

                        // Display any status messages
                        if (isset($_SESSION["error_message_login"])) {
                            echo $_SESSION["error_message_login"];
                            unset($_SESSION["error_message_login"]);
                        }    
                    ?>
                </p>

                <form class="login-form" action="../controller/UserAuthController.php?action=handleLogin" method="post">
                    <div class="username-container">
                        <label for="username">Username</label>
                        <input class="username-input" type="text" name="username" required>
                    </div>
                    <div class="password-container">
                        <label for="password">Password</label>
                        <input class="password-input" type="password" name="password" required>
                    </div>
                    <input class="submit-button" type="submit" value="Login">
                </form>

                <div class="toggler-container">
                    <p>Don't have an account? <a href="user-registration.php">Create Account</a></p>
                    <p><a class="toggler-link" href="admin-login.php">Switch to admin?</a></p>
                </div>
            </div>      
        </div>
    </div>

</body>
</html>
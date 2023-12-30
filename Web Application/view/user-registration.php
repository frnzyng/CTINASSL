<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/user-registration.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Navigation Bar -->
    <div class="container px-0">
        <header>        
            <nav>
                <h4><a href="user-login.php">BLOGSITE</a></h4>
            </nav>
        </header>
    </div>

    <div class="container">
        <div class="row justify-content-center align-items-center mx-2">
            <div class="registration-container">
                <h3>Registration Form</h3>

                <p class="status-message">
                    <?php
                        session_start();

                        // Display any error messages
                        if (isset($_SESSION["error_message"])) {
                            echo $_SESSION["error_message"];
                            unset($_SESSION["error_message"]); // Clear the error message from session
                        }
                    ?>
                </p>

                <form class="registration-form" action="../controller/UserRegistrationController.php?action=handleUserRegistration" method="post">
                    <label for="username">Username</label>
                    <input class="username-input" type="text" name="username" required><br>

                    <label for="password">Password</label>
                    <input class="password-input" type="password" name="password" required><br>

                    <label for="email">Email</label>
                    <input class="email-input" type="email" name="email" required><br>

                    <input class="submit-button" type="submit" value="Register">
                </form>

                <p>Already have an account? <a href="user-login.php">Login</a></p>
            </div>
        </div>    
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Navigation Bar -->
    <div>
        <header>        
            <nav>
                <h3>BLOGSITE</h3>
            </nav>
        </header>
    </div>

    <div class="registration-container">
        <h2>Registration Form</h2>

        <?php
        session_start();

        // Display any status messages
        if (isset($_SESSION["status_message"])) {
            echo $_SESSION["status_message"];
            unset($_SESSION["status_message"]); // Clear the error message from session
        }
        ?>
        
        <form action="../controller/UserRegistrationController.php?action=handleUserRegistration" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" required><br>
    
            <label for="password">Password</label>
            <input type="password" name="password" required><br>
    
            <label for="email">Email</label>
            <input type="email" name="email" required><br>
    
            <input type="submit" value="Register">
        </form>
        <p>Already have an account? <a href="user-login.php">Login</a></p>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/login.css">
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
 
    <!-- Login Form -->
    <div class="login-container">
        <h2>Admin Login</h2>

        <?php
        session_start();

        // Display any error messages
        if (isset($_SESSION["error_message"])) {
            echo $_SESSION["error_message"];
            unset($_SESSION["error_message"]); // Clear the error message from session
        }
        ?>

        <form action="../controller/AdminAuthController.php" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" required><br>
    
            <label for="password">Password</label>
            <input type="password" name="password" required><br>
    
            <input type="submit" value="Login">
        </form>
        <p><a class="toggle-link" href="user-login.php">Switch to user?</a></p>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
 
    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and process login
        $username = $_POST["username"];
        $password = $_POST["password"];
 
        // Database connection
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "BlogSite";
 
        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
 
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
 
        // Check login credentials
        $sql = "SELECT id, username, password FROM tblAccounts WHERE username='$username'";
        $result = $conn->query($sql);
 
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
 
            // Verify password
            if (password_verify($password, $row["password"])) {
                // Start a session and store user ID
                session_start();
                $_SESSION["user_id"] = $row["id"];
 
                // Redirect to home dashboard; changed from admin
                header("Location: home.php");
                exit();
            } else {
                echo "Invalid password";
            }
        } else {
            echo "Invalid username";
        }
 
        $conn->close();
    }
    ?>

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
        <h2>Login</h2>
        <form action="" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" required><br>
    
            <label for="password">Password</label>
            <input type="password" name="password" required><br>
    
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="index.php">Create Account</a></p>
        <p><a class="toggle-link" href="admin-login.php">Admin?</a></p>
    </div>
</body>
</html>
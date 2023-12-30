<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSite - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/user-chusername.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1f47064a19.js" crossorigin="anonymous"></script>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="container px-0 fixed-top bg-white">
        <header>        
            <nav class="nav justify-content-between align-items-center">
                <?php
                    include_once("../controller/SessionController.php");
                    $sessionController = new SessionController();

                    // Check if the account ID exists before displaying
                    $accountUsername = $sessionController->getUsername();

                    if ($accountUsername !== null) {
                        echo "<span class='greetings-container'> Hi " . $accountUsername . "! </span>";
                    } else {
                        echo "<span class='greetings-container'>Not logged in</span>";
                    }
                ?>
                <ul class="nav justify-content-between">
                    <li class="nav-item">
                        <a href="user-home.php"><i class="fa-solid fa-house"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="user-profile.php"><i class="fa-solid fa-user"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="user-settings.php"><i class="fa-solid fa-gear"></i></a>
                    </li>
                </ul>

                <a class="logout-container" href="user-login.php">Logout</a>
            </nav>
        </header>
    </div>

    <div class="container px-0">
        <div class="row justify-content-center align-items-center mx-2">
            <div class="change-username-container">
                <h4>Change Username</h4>
                <p class="status-message">
                    <?php
                        // Display any status messages
                        if (isset($_SESSION["success_message"])) {
                            echo $_SESSION["success_message"];
                            unset($_SESSION["success_message"]); // Clear the error message from session
                        }
                        else if (isset($_SESSION["error_message"])) {
                            echo $_SESSION["error_message"];
                            unset($_SESSION["error_message"]); // Clear the error message from session
                        }
                    ?>
                </p>
                <form class="change-username-form" action="../controller/UserSettingsController.php?action=handleChangeUsername" method="post">
                    <div class="username-container">
                        <label>Enter new username</label>
                        <input class="username-input" type="text" name="new_username" id="new_username" maxlength="50" required>
                    </div>  
                    <div class="password-container">
                        <label>Enter password to confirm</label>
                        <input class="password-input" type="password" name="password" id="password" required>
                    </div>
                    <div class="button-container">
                        <input class="submit-button" type="submit" value="Save Changes">
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
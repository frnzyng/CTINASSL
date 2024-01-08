<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSite - Change Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/user-main.css">
    <link rel="stylesheet" href="css/user-chemail.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1f47064a19.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- Navigation Bar -->
    <div class="container px-0 fixed-top bg-white">
        <header>        
            <nav class="nav justify-content-center align-items-center mx-3">
                <div class="greetings-container">
                    <?php
                        include_once("../controller/SessionController.php");
                        $sessionController = new SessionController();

                        // Check if the account ID exists before displaying
                        $accountUsername = $sessionController->getUsername();

                        if ($accountUsername !== null) {
                            echo "<span class='greetings'> Hi " . $accountUsername . "! </span>";
                        } 
                        else {
                            echo "<span class='greetings'>Not logged in</span>";
                        }
                    ?>
                </div>
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
                <div class="logout-container">
                    <form action="../controller/UserAuthController.php?action=handleLogout" method="post">
                        <button class="logout-button" type="submit">Logout</button>
                    </form>
                </div>
            </nav>
        </header>
    </div>

    <!-- Change Email -->
    <div class="container px-0">
        <div class="row justify-content-center align-items-center mx-2">
            <div class="change-email-container">
                <h4>Change Email</h4>
                <p class="status-message">
                    <?php
                        // Display any status messages
                        if (isset($_SESSION["success_message_change_email"])) {
                            echo $_SESSION["success_message_change_email"];
                            unset($_SESSION["success_message_change_email"]);
                        }
                        else if (isset($_SESSION["error_message_change_email"])) {
                            echo $_SESSION["error_message_change_email"];
                            unset($_SESSION["error_message_change_email"]);
                        }
                    ?>
                </p>
                <form class="change-email-form" action="../controller/UserSettingsController.php?action=handleChangeEmail" method="post">
                    <div class="email-container">
                        <label>Enter new email</label>
                        <input class="email-input" type="email" name="new_email" id="new_email" maxlength="50" required>
                    </div>  
                    <div class="password-container">
                        <label>Enter password to confirm</label>
                        <input class="password-input" type="password" name="password" id="password" minlength="4" required>
                    </div>
                    <div class="button-container">
                        <input class="submit-button" type="submit" value="Save Changes">
                    </div>
                </form>

            </div>
        </div>
    </div>

</body>
</html>
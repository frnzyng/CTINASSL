<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSite - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/user-settings.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1f47064a19.js" crossorigin="anonymous"></script>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="container px-0 fixed-top bg-white">
        <header>        
            <nav class="nav justify-content-center align-items-center mx-3">
                <?php
                    include_once("../controller/SessionController.php");
                    $sessionController = new SessionController();

                    // Check if the account ID exists before displaying
                    $accountUsername = $sessionController->getUsername();

                    if ($accountUsername !== null) {
                        echo "<span class='greetings'> Hi " . $accountUsername . "! </span>";
                    } else {
                        echo "<span class='greetings'>Not logged in</span>";
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

                <form action="../controller/UserAuthController.php?action=handleLogout" method="post">
                    <button class="logout-button" type="submit">Logout</button>
                </form>
            </nav>
        </header>
    </div>

    <div class="container px-0">
        <div class="row justify-content-center align-items-center mx-2">
            <div class="settings-block">
                <h4>Settings</h4>
                <div class="d-flex justify-content-between align-items-center">
                    <ul class="nav justify-content-between align-items-center flex-column gap-4">
                        <li>
                            <a href="user-chusername.php">Change username</i></a>
                        </li>
                        <li>
                            <a href="user-chemail.php">Change email</i></a>
                        </li>
                        <li>
                            <a href="user-chpassword.php">Change password</a>
                        </li>
                    </ul>
                </div>
                <form action="../controller/UserAuthController.php?action=handleLogout" method="post">
                    <button class="logout-button-settings" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
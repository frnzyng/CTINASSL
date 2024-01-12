<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSite - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/admin-main.css">
    <link rel="stylesheet" href="css/admin-dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1f47064a19.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js/user-accounts-chart.js"></script>

    <!-- Navigation Bar -->
    <div class="container px-0 fixed-top bg-white">
        <header>        
            <nav class="nav justify-content-center align-items-center mx-3">
                <ul class="nav justify-content-between">
                    <li class="nav-item">
                        <a href="user-home.php"><i class="fa-solid fa-house"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="user-profile.php"><i class="fa-solid fa-image-portrait"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="user-profile.php"><i class="fa-solid fa-copy"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="user-profile.php"><i class="fa-solid fa-message"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="user-settings.php"><i class="fa-solid fa-gear"></i></a>
                    </li>
                </ul>
            </nav>
        </header>
    </div>

    <?php include_once('../controller/AdminDashboardController.php'); ?>
    <div class="container px-0">
        <div class="row justify-content-center align-items-center mx-2">
            <div class="dashboard-block">
                <h4>Welcome Admin!</h4>
                <div class="dashboard-container">
                    <div class="account-management-container">
                        <div class="chart-container">
                            <canvas id="userAccountsChart" width="275" height="275"></canvas>
                        </div>
                        <h4 class="chart-title"> <?php echo implode(AdminDashboardController::getCountUserAccounts())?> Users</h4>
                        <a class="account-management-button" href="#"><i class="fa-solid fa-image-portrait button"></i>Account Management</a>
                    </div>
                    <div class="post-management-container">
                        <div class="chart-container">
                            <canvas id="postsChart" width="275" height="275"></canvas>
                        </div>
                        <h4 class="chart-title"> <?php echo implode(AdminDashboardController::getCountPosts())?> Posts</h4>
                        <a class="post-management-button" href="#"><i class="fa-solid fa-copy button"></i>Post Management</a>
                    </div>
                    <div class="comment-management-container">
                        <div class="chart-container">
                            <canvas id="commentsChart" width="275" height="275"></canvas>
                        </div>
                        <h4 class="chart-title"> <?php echo implode(AdminDashboardController::getCountComments())?> Comments</h4>
                        <a class="account-management-button" href="#"><i class="fa-solid fa-message button"></i>Comment Management</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
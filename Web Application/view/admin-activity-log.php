<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSite - Admin Activity Log</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/admin-main.css">
    <link rel="stylesheet" href="css/admin-activity-log.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1f47064a19.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js/toggler.js"></script>
    <script src="js/user-account-chart.js"></script>

    <!-- Navigation Bar -->
    <div class="container px-0 fixed-top bg-white">
        <header>        
            <nav class="nav justify-content-center align-items-center mx-3">
                <ul class="nav justify-content-between">
                    <li class="nav-item">
                        <a href="admin-dashboard.php"><i class="fa-solid fa-house"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-account-management.php"><i class="fa-solid fa-image-portrait"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-post-management.php"><i class="fa-solid fa-copy"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-comment-management.php"><i class="fa-solid fa-message"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-settings.php"><i class="fa-solid fa-gear"></i></a>
                    </li>
                </ul>
            </nav>
        </header>
    </div>

    <!-- Admin Activity Log Block -->
    <div class="container px-0">
        <div class="row justify-content-center align-items-center mx-2">
            <?php
                include_once("../controller/AdminSettingsController.php");
                try {
                    // Get all activity logs
                    $adminActivityLogs = AdminSettingsController::handleAdminActivityLogRetrieval();
                } 
                catch (Exception $e) {
                    echo "Error retrieving accounts: " . $e->getMessage();
                }
            ?>

            <div class="admin-activity-log-block">
                <h4>Admin Activity Log</h4>

                <!-- Table -->
                <div class="table-block table-responsive">
                <table class="table table-hover" id="table-user-accounts">
                        <thead>
                            <th>Activity ID</th>
                            <th>Account ID</th>
                            <th>Username</th>
                            <th>Date & Time</th>
                            <th>Action</th>
                            <th>IP Address</th>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php foreach($adminActivityLogs as $adminActivityLog): ?>
                            <tr>
                                <td><?php echo $adminActivityLog['activity_id']?></td>
                                <td><?php echo $adminActivityLog['account_id']?></td>
                                <td><?php echo $adminActivityLog['username']?></td>
                                <td><?php echo $adminActivityLog['datetime']?></td>
                                <td><?php echo $adminActivityLog['action']?></td>
                                <td><?php echo $adminActivityLog['ip_address']?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
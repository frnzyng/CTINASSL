<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSite - Account Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/admin-main.css">
    <link rel="stylesheet" href="css/admin-account-management.css">
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

    <div class="container px-0">
        <div class="row justify-content-center align-items-center mx-2">
            <div class="account-management-block">
                <h4>Account Management</h4>
                
                <!-- Chart -->
                <div class="chart-block">
                    <?php include_once('../controller/AdminDashboardController.php'); ?>
                    <div class="chart-container">
                        <canvas id="userAccountsChart" width="250" height="250"></canvas>
                    </div>
                    <h4> <?php echo implode(AdminDashboardController::getCountAccounts())?> Users</h4>
                </div>

                <!-- Table -->
                <div class="table-block table-responsive">
                    <?php
                        include_once("../controller/AdminAccountManagementController.php");
                        try {
                            // Get all accounts
                            $accounts = AdminAccountManagementController::handleAccounRetrieval();
                        } 
                        catch (Exception $e) {
                            echo "Error retrieving posts: " . $e->getMessage();
                        }
                    ?>
                    <p class="status-message">
                        <?php
                            session_start();
                            // Display any status messages
                            if (isset($_SESSION["success_message_edit_account"])) {
                                echo $_SESSION["success_message_edit_account"];
                                unset($_SESSION["success_message_edit_account"]); // Clear the error message from session
                            }
                            else if (isset($_SESSION["error_message_edit_account"])) {
                                echo $_SESSION["error_message_edit_account"];
                                unset($_SESSION["error_message_edit_account"]); // Clear the error message from session
                            }
                            else if (isset($_SESSION["success_message_delete_account"])) {
                                echo $_SESSION["success_message_delete_account"];
                                unset($_SESSION["success_message_delete_account"]);
                            }
                            else if (isset($_SESSION["error_message_delete_account"])) {
                                echo $_SESSION["error_message_delete_account"];
                                unset($_SESSION["error_message_delete_account"]);
                            }
                        ?>
                    </p>
                    <table class="table table-hover" id="table-user-accounts">
                        <thead>
                            <th>Account ID</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Email</th>
                            <th>Action</th>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php foreach($accounts as $account): ?>
                            <tr>
                                <td><?php echo $account['account_id']?></td>
                                <td><?php echo $account['username']?></td>
                                <td><?php echo $account['password']?></td>
                                <td><?php echo $account['email']?></td>
                                <td>
                                    <a href="javascript:void(0);" onclick="Toggler.toggleEditAccount(<?php echo $account['account_id']; ?>)"><i class="fa-solid fa-pencil"></i></a>
                                    <form class="delete-form" action="../controller/AdminAccountManagementController.php?action=handleDeleteAccount" method="post" onsubmit="return confirm('Are you sure you want to delete this account?');">
                                        <input type="hidden" name="account_id" id="account_id" value="<?php echo $account['account_id']; ?>">
                                        <button class="delete-button" type="submit"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>    
                                </td>
                            </tr>
                            <!-- Edit Account -->
                            <div class="edit-account-block">
                                <div class="edit-account-container" id="edit-account-container<?php echo $account['account_id']; ?>">
                                    <h3>Edit Account</h3>

                                    <form class="edit-account-form" action="../controller/AdminAccountManagementController.php?action=handleEditAccount" method="post">
                                        <input type="hidden" name="account_id" value="<?php echo $account['account_id']; ?>">
                                        <div class="edit-username-container">
                                            <label>Username</label>
                                            <input class="edit-username-input" type="text" name="new_username" id="new_username" maxlength="25" required value="<?php echo $account['username']; ?>">
                                        </div>
                                        <div class="edit-password-container">
                                            <label>Password</label>
                                            <input class="edit-password-input" type="password" name="new_password" id="new_password" minlength="4" required value="<?php echo $account['password']; ?>">
                                        </div>
                                        <div class="edit-email-container">
                                            <label>Email</label>
                                            <input class="edit-email-input" type="email" name="new_email" id="new_email" maxlength="50" required value="<?php echo $account['email']; ?>">
                                        </div>
                                        <div class="button-container">
                                            <a class="cancel-button" href="javascript:void(0);" onclick="Toggler.toggleEditAccount(<?php echo $account['account_id']; ?>)">Cancel</a>
                                            <input class="submit-button" type="submit" value="Save">
                                        </div>
                                    </form> 
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
  
</body>
</html>
<?php

$action = isset($_GET['action']) ? $_GET['action'] : '';
$controller = new AdminDashboardController();

if ($action === 'getCountAccounts') {
    echo json_encode($controller->getCountAccounts());
}
else if ($action === 'getCountPosts') {
    echo json_encode($controller->getCountPosts());
}
else if ($action === 'getCountComments') {
    echo json_encode($controller->getCountComments());
}

class AdminDashboardController {

    public static function getCountAccounts() {
        try {
            include_once("../model/UserAccountModel.php");

            $count = UserAccountModel::countAccounts();

            return $count;
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }

    public static function getCountPosts() {
        try {
            include_once("../model/UserPostModel.php");

            $count = UserPostModel::countPosts();

            return $count;
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }

    public static function getCountComments() {
        try {
            include_once("../model/UserCommentModel.php");
            
            $count = UserCommentModel::countComments();

            return $count;
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }
}
?>
<?php

class AdminSettingsController {
    public static function handleAdminLogRetrieval() {
        try {
            include_once("../model/AdminAccountModel.php");
            $retrievedAdminLog = AdminAccountModel::getAdminLog();

            return $retrievedAdminLog;
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }

    public static function handleAdminActivityLogRetrieval() {
        try {
            include_once("../model/AdminAccountModel.php");
            $retrievedActivityLog = AdminAccountModel::getActivityLog();

            return $retrievedActivityLog;
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }
}
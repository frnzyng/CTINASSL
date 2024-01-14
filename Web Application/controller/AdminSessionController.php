<?php
class AdminSessionController {
    public function startSession($admin_account_id, $admin_username) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['admin_account_id'] = $admin_account_id;
        $_SESSION['admin_username'] = $admin_username;
    }

    public function endSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
    }

    public function getAdminAccountId() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['admin_account_id']) ? $_SESSION['admin_account_id'] : null;
    }

    public function getAdminUsername() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : null;
    }
}
?>

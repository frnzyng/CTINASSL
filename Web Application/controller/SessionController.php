<?php
class SessionController {
    public function startSession($account_id, $username) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['account_id'] = $account_id;
        $_SESSION['username'] = $username;
    }

    public function endSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
    }

    public function getAccountId() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['account_id']) ? $_SESSION['account_id'] : null;
    }

    public function getUsername() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['username']) ? $_SESSION['username'] : null;
    }
}
?>

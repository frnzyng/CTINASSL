<?php
class SessionController {
    public function startSession($account_id) {
        session_start();
        $_SESSION['account_id'] = $account_id;
    }

    public function endSession() {
        session_start();
        session_unset();
        session_destroy();
    }

    public function getAccountId() {
        session_start();
        return isset($_SESSION['account_id']) ? $_SESSION['account_id'] : null;
    }
}
?>
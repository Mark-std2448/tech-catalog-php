<?php
require_once "BaseTechController.php";

class LogoutController extends BaseTechController {
    
    public function process_response() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['is_logged'] = false;
        unset($_SESSION['user_name']); 
        header("Location: /login");
        exit;
    }

    public function get(array $context) {
    }

    public function post(array $context = []) {
    }
}
<?php

class LoginRequiredMiddleware extends BaseMiddleware {
    
    public function handle($request) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $is_logged = isset($_SESSION['is_logged']) ? $_SESSION['is_logged'] : false;

        if (!$is_logged) {
            if ($_SERVER['REQUEST_URI'] !== '/login') {
                header("Location: /login");
                exit;
            }
        }
    }
}
<?php
require_once "BaseTechController.php";

class SetWelcomeController extends BaseTechController {
    
    public function get(array $context) {
        if (isset($_GET['message']) && trim($_GET['message']) !== '') {
            $_SESSION['welcome_message'] = $_GET['message'];
        }
        
        $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
        header("Location: $url");
        exit;
    }
}
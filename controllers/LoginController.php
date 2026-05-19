<?php
require_once "BaseTechController.php";

class LoginController extends BaseTechController {
    
    public function process_response() {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params(36000);
            session_start();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->post();
        }
        
        return $this->get([]);
    }

    public function get(array $context) {
        if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] === true) {
            header("Location: /");
            exit;
        }

        echo $this->twig->render("login.twig", $context);
    }

    public function post(array $context = []) {
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        $pdo = new PDO("mysql:host=localhost;dbname=tech_catalog;charset=utf8", "root", "");
        
        $query = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $query->execute(['username' => $username]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['password'] === $password) {
            $_SESSION['is_logged'] = true;
            
            $_SESSION['user_name'] = $user['username'];

            header("Location: /");
            exit;
        } else {
            return $this->get(['error' => 'Неверное имя пользователя или пароль']);
        }
    }
}
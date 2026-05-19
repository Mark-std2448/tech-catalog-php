<?php

abstract class BaseTechController {
    protected PDO $pdo;
    protected $params = [];
    protected $twig;
    
    public $template = "";
    public $title = "";

    public function setPDO(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function setParams(array $params) {
        $this->params = $params;
    }

    public function setTwig($twig) {
        $this->twig = $twig;
    }

    public function getContext(): array {
        $query = $this->pdo->query("SELECT * FROM product_types");
        $types = $query->fetchAll(PDO::FETCH_ASSOC);

        return [
            'title' => $this->title,
            'types' => $types 
        ];
    }

public function process_response() {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params(36000);
            session_start();
        }

        if (!isset($_SESSION['history'])) {
            $_SESSION['history'] = [];
        }

        $current_url = urldecode($_SERVER['REQUEST_URI']);

        if (empty($_SESSION['history']) || end($_SESSION['history']) !== $current_url) {
            $_SESSION['history'][] = $current_url;
            
            if (count($_SESSION['history']) > 10) {
                array_shift($_SESSION['history']);
            }
        }

        $context = $this->getContext();
        
        $context["my_session_message"] = isset($_SESSION['welcome_message']) ? $_SESSION['welcome_message'] : "";
        $context["history_pages"] = array_reverse($_SESSION['history']);
        
        return $this->get($context);
    }

    public function get(array $context) {
        echo $this->twig->render($this->template, $context);
    } 

    public function post(array $context) {
        $this->get($context);
    }

    public function getPDO(): PDO {
        return $this->pdo;
    }
}
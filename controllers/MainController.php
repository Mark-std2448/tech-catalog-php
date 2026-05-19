<?php
require_once "BaseTechController.php";

class MainController extends BaseTechController {
    public $template = "main.twig";
    public $title = "Главная страница";

    public function getContext(): array
    {
        $context = parent::getContext();
        $type = isset($_GET['type']) ? $_GET['type'] : null;
        
        if ($type) {
            $query = $this->pdo->prepare("SELECT * FROM products WHERE type = :type");
            $query->bindValue("type", $type);
            $query->execute();
            $context['objects'] = $query->fetchAll();

            $typeQuery = $this->pdo->prepare("SELECT id FROM product_types WHERE name = :name LIMIT 1");
            $typeQuery->bindValue("name", $type);
            $typeQuery->execute();
            $typeData = $typeQuery->fetch();

            $context['current_type_name'] = $type;
            if ($typeData) {
                $context['current_type_id'] = $typeData['id'];
            }
        } else {
            $query = $this->pdo->query("SELECT * FROM products");
            $context['objects'] = $query->fetchAll();
            $context['current_type_name'] = null;
        }
        
        return $context;
    }

    public function get(array $context) {
        echo $this->twig->render($this->template, $context);
    }
}
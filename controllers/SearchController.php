<?php
require_once "BaseTechController.php";

class SearchController extends BaseTechController {
    public $template = "search.twig";
    public $title = "Поиск товаров";

    public function getContext(): array
    {
        $context = parent::getContext();
        
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        $description = isset($_GET['description']) ? $_GET['description'] : ''; 

        $context['selected_type'] = $type;
        $context['search_title'] = $title;
        $context['search_description'] = $description;

        $sql = "SELECT * FROM products WHERE 1=1";
        $params = [];

        if ($type !== '') {
            $sql .= " AND type = :type";
            $params['type'] = $type;
        }

        if ($title !== '') {
            $sql .= " AND title LIKE :title";
            $params['title'] = '%' . $title . '%';
        }

        if ($description !== '') {
            $sql .= " AND description LIKE :description"; 
            $params['description'] = '%' . $description . '%';
        }

        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        
        $context['products'] = $query->fetchAll();

        return $context;
    }

    public function get(array $context) {
        echo $this->twig->render($this->template, $context);
    }
}
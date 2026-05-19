<?php
require_once "BaseTechController.php";

class ObjectController extends BaseTechController {
    public $template = "product_info.twig"; 

    public function getContext(): array
    {
        $context = parent::getContext();
        
        $query = $this->pdo->prepare("SELECT title, image, description, info FROM products WHERE id = :my_id");
        $query->bindValue("my_id", $this->params['id']);
        $query->execute();
        
        $data = $query->fetch();
        
        if ($data) {
            $context['title'] = $data['title'];
            $context['image'] = $data['image'];
            $context['description'] = $data['description'];
            $context['info'] = $data['info'];
            $context['id'] = $this->params['id']; 
            
            $this->title = $data['title'];
        }

        return $context;
    }

    public function get(array $context) {
        $raw_url = $_SERVER["REQUEST_URI"];

        if (strpos($raw_url, 'show=image') !== false) {
            $this->template = "base_image.twig";
        } elseif (strpos($raw_url, 'show=info') !== false) {
            $this->template = "smartphone_info.twig";
        } else {
            $this->template = "product_info.twig";
        }

        if ($this->template == "base_image.twig") {
            $this->title = $context['title'] . " - Фото";
        } elseif ($this->template == "smartphone_info.twig") {
            $this->title = $context['title'] . " - Описание";
        }

        echo $this->twig->render($this->template, $context);
    }
}
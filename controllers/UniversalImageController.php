<?php
require_once "BaseTechController.php";

class UniversalImageController extends BaseTechController {
    public $template = "base_image.twig"; 

    public function getContext(): array
    {
        $context = parent::getContext();
        
        $query = $this->pdo->prepare("SELECT title, image FROM products WHERE id = :my_id");
        $query->bindValue("my_id", $this->params['id']);
        $query->execute();
        
        $data = $query->fetch();
        
        if ($data) {
            $context['image'] = $data['image'];
            $context['id'] = $this->params['id'];
            $this->title = $data['title'];
        }

        return $context;
    }

    public function get() {
        echo $this->twig->render($this->template, $this->getContext());
    }
}
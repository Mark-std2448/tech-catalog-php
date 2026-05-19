<?php
require_once "BaseTechController.php";

class UniversalInfoController extends BaseTechController {
    public $template = "smartphone_info.twig"; 

    public function getContext(): array
    {
        $context = parent::getContext();
        
        $query = $this->pdo->prepare("SELECT title, info FROM products WHERE id = :my_id");
        $query->bindValue("my_id", $this->params['id']);
        $query->execute();
        
        $data = $query->fetch();
        
        if ($data) {
            $context['info'] = $data['info'];
            $context['id'] = $this->params['id'];
            $this->title = $data['title'];
        }

        return $context;
    }

    public function get() {
        echo $this->twig->render($this->template, $this->getContext());
    }
}
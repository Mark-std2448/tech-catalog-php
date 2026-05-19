<?php
require_once "BaseTechController.php";

class TypeCreateController extends BaseTechController {
    public $template = "type_create.twig";
    public $title = "Добавление нового типа";

    public function get(array $context) {
        echo $this->twig->render($this->template, $context);
    }

    public function post(array $context) {
        $name = $_POST['name'];
        
        $sql = "INSERT INTO product_types (name, image) VALUES (:name, '')";
        $query = $this->pdo->prepare($sql);
        $query->bindValue("name", $name);
        $query->execute();
        
        $context['message'] = "Новый тип объектов успешно добавлен!";

        $new_context = $this->getContext();
        $new_context['message'] = $context['message'];

        $this->get($new_context);
    }
}
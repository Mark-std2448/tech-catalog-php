<?php
require_once "BaseTechController.php";

class ProductCreateController extends BaseTechController {
    public $template = "product_create.twig";
    public $title = "Добавление нового товара";

    public function get(array $context) {
        echo $this->twig->render($this->template, $context);
    }

    public function post(array $context) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $info = $_POST['info'];
        
        $image_url = ''; 
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $name = $_FILES['image']['name'];
            
            move_uploaded_file($tmp_name, "../public/media/$name");
            
            $image_url = "/media/$name";
        }

        $sql = <<<EOL
INSERT INTO products (title, description, type, info, image)
VALUES (:title, :description, :type, :info, :image_url)
EOL;

        $query = $this->pdo->prepare($sql);
        $query->bindValue("title", $title);
        $query->bindValue("description", $description);
        $query->bindValue("type", $type);
        $query->bindValue("info", $info);
        $query->bindValue("image_url", $image_url);
        
        $query->execute();
        
        $new_id = $this->pdo->lastInsertId();
        
        $context['message'] = "Вы успешно создали объект техники!";
        $context['new_id'] = $new_id;

        $this->get($context);
    }
}
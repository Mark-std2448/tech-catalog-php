<?php
require_once "BaseTechController.php";

class ProductUpdateController extends BaseTechController {
    public $template = "product_edit.twig";
    public $title = "Редактирование товара";

    public function get(array $context) {
        $id = $this->params['id']; 

        $query = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $query->bindValue("id", $id);
        $query->execute();
        $product = $query->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            header("Location: /404");
            exit;
        }

        $context['id'] = $product['id'];
        $context['title_value'] = $product['title']; 
        $context['description'] = $product['description'];
        $context['info'] = $product['info'];
        $context['current_type'] = $product['type'];
        $context['image'] = $product['image'];

        echo $this->twig->render($this->template, $context);
    }

    public function post(array $context) {
        $id = $this->params['id'];
        
        $title = $_POST['title'];
        $type = $_POST['type'];
        $description = $_POST['description'];
        $info = $_POST['info'];
        $image_url = $_POST['old_image']; 

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $file_name = $_FILES['image']['name'];
            $target_dir = __DIR__ . "/../public/media/";
            
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            move_uploaded_file($tmp_name, $target_dir . $file_name);
            $image_url = "/media/$file_name";
        }

        $sql = <<<EOL
UPDATE products 
SET title = :title, type = :type, description = :description, info = :info, image = :image 
WHERE id = :id
EOL;

        $query = $this->pdo->prepare($sql);
        $query->bindValue("title", $title);
        $query->bindValue("type", $type);
        $query->bindValue("description", $description);
        $query->bindValue("info", $info);
        $query->bindValue("image", $image_url);
        $query->bindValue("id", $id);
        $query->execute();

        header("Location: /product/" . $id);
        exit;
    }
}
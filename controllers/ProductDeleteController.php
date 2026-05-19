<?php
require_once "BaseTechController.php";

class ProductDeleteController extends BaseTechController {
    
    public function post(array $context)
    {
        $id = $_POST['id']; 

        $sql = <<<EOL
DELETE FROM products WHERE id = :id
EOL;

        $query = $this->pdo->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();
        
        header("Location: /");
        exit;
    }
}
<?php
require_once "BaseTechController.php";

class TypeDeleteController extends BaseTechController {
    
    public function process_response() {
        if (isset($this->params['id'])) {
            $id = $this->params['id'];

            $query = $this->pdo->prepare("DELETE FROM product_types WHERE id = :id");
            $query->execute(['id' => $id]);
        }

        header("Location: /");
        exit;
    }
}
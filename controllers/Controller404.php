<?php
require_once "BaseTechController.php";

class Controller404 extends BaseTechController {
    public $template = "404.twig"; 
    public $title = "Страница не найдена";

    public function get(array $context) {
        header("HTTP/1.1 404 Not Found");
        echo $this->twig->render($this->template, $context);
    }
}
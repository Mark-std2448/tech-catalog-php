<?php
require_once "LaptopController.php";
class LaptopInfoController extends LaptopController {
    public $template = "laptop_info.twig";
    public $title = "Ноутбуки - Описание";
    public function getContext(): array {
        return parent::getContext();
    }
}
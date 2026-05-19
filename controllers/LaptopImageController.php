<?php
require_once "LaptopController.php";
class LaptopImageController extends LaptopController {
    public $template = "base_image.twig";
    public $title = "Ноутбуки - Фото";
    public function getContext(): array {
        $context = parent::getContext();
        $context['image'] = "/images/laptop.jpg";
        return $context;
    }
}
<?php
require_once "SmartphoneController.php";
class SmartphoneImageController extends SmartphoneController {
    public $template = "base_image.twig";
    public $title = "Смартфоны - Фото";
    public function getContext(): array {
        $context = parent::getContext();
        $context['image'] = "/images/smartphone.jpg";
        return $context;
    }
}
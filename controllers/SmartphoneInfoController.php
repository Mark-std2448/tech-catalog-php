<?php
require_once "SmartphoneController.php";
class SmartphoneInfoController extends SmartphoneController {
    public $template = "smartphone_info.twig";
    public $title = "Смартфоны - Описание";
    public function getContext(): array {
        return parent::getContext();
    }
}
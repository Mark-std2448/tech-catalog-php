<?php
require_once "TwigBaseController.php";

class SmartphoneController extends TwigBaseController {
    public $template = "smartphone_info.twig"; 
    public $title = "Смартфоны";

    public function get() {
        echo $this->twig->render($this->template, $this->getContext());
    }
}
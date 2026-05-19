<?php
require_once "TwigBaseController.php";

class LaptopController extends TwigBaseController {
    public $template = "laptop_info.twig";
    public $title = "Ноутбуки";

    public function get() {
        echo $this->twig->render($this->template, $this->getContext());
    }
}
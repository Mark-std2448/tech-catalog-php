<?php

abstract class TwigBaseController {
    public PDO $pdo;
    protected \Twig\Environment $twig;
    public array $params = []; 
    public $title = "";
    public $template = "";

    public function setPDO(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function setTwig($twig) {
        $this->twig = $twig;
    }

    public function setParams(array $params) {
        $this->params = $params;
    }

    public function getContext(): array {
        return [
            "menu" => [
                ["title" => "Главная", "url" => "/"],
            ]
        ];
    }

    abstract public function get();
}
<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../vendor/autoload.php';
require_once '../framework/autoload.php';

require_once "../controllers/BaseTechController.php";
require_once "../controllers/MainController.php";
require_once "../controllers/ObjectController.php";
require_once "../controllers/SearchController.php";
require_once "../controllers/ProductCreateController.php";
require_once "../controllers/ProductDeleteController.php";
require_once "../controllers/TypeCreateController.php";
require_once "../controllers/TypeDeleteController.php";
require_once "../controllers/ProductUpdateController.php";
require_once "../controllers/Controller404.php";

require_once "../framework/BaseMiddleware.php";
require_once "../middlewares/LoginRequiredMiddleware.php";
require_once "../controllers/SetWelcomeController.php";

require_once "../controllers/LoginController.php";
require_once "../controllers/LogoutController.php";

$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader, [
    "debug" => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

$pdo = new PDO("mysql:host=localhost;dbname=tech_catalog;charset=utf8", "root", "");

$router = new Router($twig, $pdo);

$router->add("/", MainController::class);
$router->add("/search", SearchController::class);
$router->add("/set-welcome", SetWelcomeController::class);
$router->add("/product/(?P<id>\d+)", ObjectController::class);

$router->add("/product/create", ProductCreateController::class)->middleware(new LoginRequiredMiddleware());
$router->add("/type/create", TypeCreateController::class)->middleware(new LoginRequiredMiddleware());
$router->add("/product/delete", ProductDeleteController::class)->middleware(new LoginRequiredMiddleware());
$router->add("/product/(?P<id>\d+)/edit", ProductUpdateController::class)->middleware(new LoginRequiredMiddleware());
$router->add("/type/(?P<id>\d+)/delete", TypeDeleteController::class)->middleware(new LoginRequiredMiddleware());

$router->add("/login", LoginController::class);
$router->add("/logout", LogoutController::class);

$router->get_or_default(Controller404::class);
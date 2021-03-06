<?php
use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;


require_once('../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$config = [
              'userClass'=>
                  'app\models\UserModel'
              ,
              'web' =>[
                  'dsn' => $_ENV['DB_DSN'],
                  'root' => $_ENV['ROOT'],
                  'pass' => $_ENV['PASSWORD'],
              ],
];
$app = new Application(dirname(__DIR__) , $config );

$app->router->get('/',[SiteController::class , "home"]);

$app->router->get('/contact',[SiteController::class , "contactView"]);


$app->router->post('/contact',[SiteController::class , "data_handeling"]);
/**
 * LOGIN ROUTES
 */
$app->router->get('/login',[AuthController::class , "login"]);


$app->router->post('/login',[AuthController::class , "login"]);
$app->router->get('/logout',[AuthController::class , "logout"]);

/**
 * POST ROUTES
 */
$app->router->get('/register',[AuthController::class , "register"]);


$app->router->post('/register',[AuthController::class , "register"]);


$app->run();
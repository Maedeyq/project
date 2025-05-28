// public/index.php
<?php

define('ROOT_PATH', dirname(__DIR__));


require_once ROOT_PATH . '/vendor/autoload.php';


use Dotenv\Dotenv;
use App\core\Router;
use App\core\Database;


$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//date_default_timezone_set(require_once ROOT_PATH . '/app/config/app.php')['timezone'];

$router = new Router();


$router -> get ('/', 'homeController@index');
$router -> get ('/home', 'HomeController@index');


$router->get('/signup', 'AuthController@showSignupForm');
$router->post('/signup', 'AuthController@signup');
$router->get('/signin', 'AuthController@showSigninForm');
$router->post('/signin', 'AuthController@signin');
$router->get('/logout', 'AuthController@logout');

$router->get('/profile', 'UserController@showProfile');
$router->post('/profile/edit', 'UserController@updateProfile');

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    echo "Successfully connected to the database!";
    

} catch (Exception $e) {
    echo "Error connecting to database: " . $e->getMessage();
}



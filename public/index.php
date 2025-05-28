// public/index.php
<?php

define('ROOT_PATH', dirname(__DIR__));


require_once ROOT_PATH . '/vendor/autoload.php';


use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use App\Core\Database;

try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    echo "Successfully connected to the database!";
    

} catch (Exception $e) {
    echo "Error connecting to database: " . $e->getMessage();
}

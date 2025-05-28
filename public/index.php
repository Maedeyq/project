// public/index.php
<?php

// تعریف ثابت ROOT_PATH برای دسترسی آسان به ریشه پروژه
define('ROOT_PATH', dirname(__DIR__));

// لود کردن Composer Autoloader
// این خط برای بارگذاری خودکار کلاس‌ها از دایرکتوری vendor و app ضروریه
require_once ROOT_PATH . '/vendor/autoload.php';

// بارگذاری متغیرهای محیطی از فایل .env
// اگر از vlucas/phpdotenv استفاده میکنید
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

// تنظیمات Error Reporting (فقط برای محیط توسعه - Development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// تنظیم Timezone
$appConfig = require_once ROOT_PATH . '/app/config/app.php';
if (is_array($appConfig) && isset($appConfig['timezone'])) {
    date_default_timezone_set($appConfig['timezone']);
} else {
    // Handle error: config file missing or invalid
    die('Invalid app configuration: timezone not set.');
}

// در این مرحله، ما هنوز سیستم روتینگ رو نساختیم.
// فعلاً برای تست اتصال به دیتابیس میتونیم از کد زیر استفاده کنیم:
use App\Core\Database;

try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    echo "Successfully connected to the database!";
    // میتونید یه کوئری ساده هم اجرا کنید برای تست
    // $stmt = $conn->query("SELECT 1");
    // $result = $stmt->fetchColumn();
    // echo " Query result: " . $result;

} catch (Exception $e) {
    echo "Error connecting to database: " . $e->getMessage();
}

// در مراحل بعدی، اینجا سیستم روتینگ و درخواست‌ها رو هندل خواهیم کرد.
// require_once ROOT_PATH . '/app/Core/Router.php';
// $router = new App\Core\Router();
// $router->dispatch($_SERVER['REQUEST_URI']);
<?php
namespace App\Core;

use  PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $conn;
    private $config;

    private function __construct()
    {
        $this->config = require __DIR__ . '/../../config/database.php';
        
        $dsn="{$this->config['driver']}:host={$this->config['host']};dbname={$this->config['database']};charset={$this->config['charset']}";
        $options=[
            PDO:: ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try{
            $this ->$conn = new PDO ($dsn, $this-> config['username'], $this->config ['password'], $options);
        } catch (PDOException $e){
            die ("connection faild:". $e-> getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();      
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}

?>
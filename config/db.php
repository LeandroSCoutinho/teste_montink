<?php
require_once __DIR__ . '/env.php';
loadEnv();

class DB {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {
            $host = $_ENV['DB_HOST'];
            $dbname = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASS'];

            self::$instance = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ]);
        }
        return self::$instance;
    }
}

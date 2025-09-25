<?php
class Database
{
    private static $pdo;

    public static function getInstance()
    {
        if (!isset(self::$pdo)) {
            $dsn = 'mysql:host=localhost;dbname=php_master;charset=utf8mb4';
            $user = 'root';
            $pass = 'root'; // 環境に合わせて変更

            try {
                self::$pdo = new PDO($dsn, $user, $pass);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                die('データベース接続に失敗しました。');
            }
        }
        return self::$pdo;
    }
}

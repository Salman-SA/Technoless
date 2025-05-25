<?php
$host = 'localhost';
$db = 'technoless';
$user = 'imamu1234';
$pass = 'imamu1234';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";


try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>

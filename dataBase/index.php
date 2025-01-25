<?php
require __DIR__ .'/../vendor/autoload.php';
require __DIR__ .'/dataBase.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$host = $_ENV['HOST_BASE']; // Или IP сервера БД
$dbname = $_ENV['DB_NAME'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
$database = new DataBase($host, $username, $password, $dbname);
$result = $database->getParametr('IamAdmin', 'users');

header('Content-Type: application/json'); // Устанавливаем заголовок JSON
echo json_encode($result, JSON_PRETTY_PRINT);
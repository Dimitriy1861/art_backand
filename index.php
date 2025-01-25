<?php
require 'vendor/autoload.php';
require __DIR__.'/token/generate/index.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(204);
    exit();
}
$host = $_ENV['HOST_BASE']; // Или IP сервера БД
$dbname = $_ENV['DB_NAME'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$secretKey = $_ENV['SECRET_KEY'];

$result= createJwt(['displayName'=>'admin', 'role'=>'admin'], 600, 'refresh');
echo $result;
exit();
?>
<?php
require_once __DIR__ ."/../dataBase/dataBase.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/../');
$dotenv->load();
$host = $_ENV['HOST_BASE']; // Или IP сервера БД
$dbname = $_ENV['DB_NAME'];
$userDB = $_ENV['DB_USER'];
$passDB = $_ENV['DB_PASS'];
$database = new Database($host, $userDB, $passDB,  $dbname);


echo json_encode($database->getTable('picters'));
echo 'or';
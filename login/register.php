<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . "/../dataBase/dataBase.php";
require_once __DIR__ . "/loginin.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host = $_ENV['HOST_BASE'];
$usernameDB = $_ENV['DB_USER'];
$passwordDB = $_ENV['DB_PASS'];
$database = $_ENV['DB_NAME'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database($host, $usernameDB, $passwordDB, $database);
    $displayName = $_POST["displayName"];
    $password = $_POST["password"];
    $data = $database->getParametr($displayName, 'users');
    if ($displayName && $password) {
        if ($data['displayName'] !== $displayName) {
            if ($database->register($displayName, $password)) {
                echo json_encode(loginIn($displayName, $password), JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([
                    "status" => false,
                    "message" => "Ощибка сервера. Попробуйте позже",
                ], JSON_UNESCAPED_UNICODE);
            }
        }else {
            echo json_encode([
                "status" => false,
                "message" => "Пользователь с таким логином существует",
            ], JSON_UNESCAPED_UNICODE);
        }
    } else {
        echo json_encode('Ввидете имя и пароль', JSON_UNESCAPED_UNICODE);
    }

}



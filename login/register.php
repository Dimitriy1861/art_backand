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
    $email = $_POST["email"];
    $password = $_POST["password"];
    $login=$_POST['login'];
    $data = $database->getParametr($email, 'users');
    if ($email && $password) {
        if (!$data['email']) {
            header('Content-Type: application/json; charset=utf-8');
            if ($database->register($email, $password, $login)) {
                $result =loginIn($email, $password);
                echo json_encode($result, JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([
                    "status" => false,
                    "message" => "Ощибка сервера. Попробуйте позже",
                ], JSON_UNESCAPED_UNICODE);
            }
        }else {
            echo json_encode([
                "status" => false,
                "message" => "Пользователь с такой почтой существует",
            ], JSON_UNESCAPED_UNICODE);
        }
    } else {
        echo json_encode('Введите имя и пароль', JSON_UNESCAPED_UNICODE);
    }

}



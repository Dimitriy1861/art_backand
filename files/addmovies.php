<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/../');
$dotenv->load();
require_once __DIR__ . '/../dataBase/dataBase.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $ranger = $_POST["ranger"];
    $path_to_movie = $_POST["path"];
    $data = [
        "name" => $name,
        "description" => $description,
        "ranger" => $ranger,
        "path_to_movie" => $path_to_movie
    ];
    $host = $_ENV['HOST_BASE'];
    $dbname = $_ENV['DB_NAME'];
    $userDB = $_ENV['DB_USER'];
    $passDB = $_ENV['DB_PASS'];
    $database = new Database($host, $userDB, $passDB, $dbname);
    if ($database->setMovies($data)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Ошибка на записи в базу
        данных"], JSON_UNESCAPED_UNICODE);
    }

}

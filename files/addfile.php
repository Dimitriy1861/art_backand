<?php
require_once __DIR__ . '/../dataBase/dataBase.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/../');
$dotenv->load();
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["image"])) {

    $uploadDir = __DIR__ . "/../pictures/"; // Папка для загрузки
    $file = $_FILES["image"];

    // Получаем расширение файла
    $fileExt = pathinfo($file["name"], PATHINFO_EXTENSION);

    // Разрешенные форматы
    $allowedExts = ["jpg", "jpeg", "png", "gif", "webp"];

    if (!in_array(strtolower($fileExt), $allowedExts)) {
        die("Ошибка: Недопустимый формат файла!");
    }

    // Генерируем уникальное имя
    $newFileName = uniqid() . "." . $fileExt;
    $targetPath = $uploadDir . $newFileName;

    // Проверяем размер (не больше 2MB)
//    if ($file["size"] > 2 * 1024 * 1024) {
//        die("Ошибка: Файл слишком большой!");
//    }

    if ($file["error"] !== UPLOAD_ERR_OK) {
        echo "Ошибка загрузки: " . $file["error"];
        exit;
    }


    // Перемещаем файл в папку uploads/
    if (move_uploaded_file($file["tmp_name"], $targetPath)) {
      setToBD($targetPath, $file["tmp_name"]);

    } else {
        return [
            "status" => "error",
            "message" => "Ошибка загрузки файла!"
        ];
        }

} else {
    return [
        "status" => "error",
        "message"=> "Ошибка: Файл не загружен!"
    ];
}
function setToBD($path, $fileName)

{
    $description = $_POST["description"];
    $ranger = $_POST["ranger"];
    $data = [
        "path" => $path,
        "name" => $fileName,
        "description" => $description,
        "ranger" => $ranger
    ];
    $host = $_ENV['HOST_BASE']; // Или IP сервера БД
    $dbname = $_ENV['DB_NAME'];
    $userDB = $_ENV['DB_USER'];
    $passDB = $_ENV['DB_PASS'];
    $database = new Database($host, $userDB, $passDB,  $dbname);
    if ($database->setFiles($data)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message"=>"Ошибка на записи в базу
        данных"], JSON_UNESCAPED_UNICODE);
    }
}

?>


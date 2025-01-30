<?php
require_once __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

class DataBase
{
    private $pdo;

    public function __construct($host, $username, $password, $dbname)
    {

        $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function prapare()
    {
    }

    public function getTable($tableName)
    {
        $stmt = $this->pdo->query("SELECT * FROM $tableName");
        return $stmt->fetchAll(); // Возвращаем массив данных
    }

    public function getParametr($email, $tableName)
    {
        $table = $this->getTable($tableName);
        $stmt = $this->pdo->prepare("SELECT * FROM $tableName WHERE email = :email"); // Подготовка запроса
        $stmt->execute(['email' => $email]); // Выполнение запроса с подстановкой значения
        return $stmt->fetch(); // Получаем одну строку
    }

    public function setFiles($data)
    {
        extract($data);
        $tmt = $this->pdo->prepare("INSERT INTO `picters` (path_to_picter, name, description, ranger)
    VALUES (:path_to_picter, :name, :description, :ranger)");

        $result = $tmt->execute([
            'path_to_picter' => $path,
            'name' => $name,
            'description' => $description,
            'ranger' => $ranger
        ]);
        return $result;

    }

    public function setMovies($data) {
        extract($data);
        $tmt=$this->pdo->prepare("INSERT INTO `movies` (path_to_movie, name, description, ranger)
    VALUES (:path_to_movie, :name, :description, :ranger)");
        var_dump('ranger: ',$ranger);
    $result=$tmt->execute([
        'path_to_movie' => $path_to_movie,
        'name' => $name,
        'description' => $description,
        'ranger' => $ranger,
    ]);
    return $result;
    }

    public function register($email, $password, $login)
    {
        $tmt = $this->pdo->prepare("INSERT INTO `users` (`email`, `password_hash`, `role`, `name`)
    VALUES (:email, :password_hash, :role, :name)");
        $result = $tmt->execute([
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'role' => "gost",    // Здесь передаем строку "gost"
            'name' => $login     // Здесь передаем строку "name"
        ]);
        return $result;
    }
}

?>
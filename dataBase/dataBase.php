<?php
require_once __DIR__.'/../vendor/autoload.php';



class DataBase{
    private $pdo;
    public function __construct($host, $username, $password, $dbname){

        $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC  // ВАЖНО: Теперь только ассоциативный массив!
        ]);
    }

    public function prapare(){}
    public function getTable($tableName){
        $stmt = $this->pdo->query("SELECT * FROM $tableName");
        return $stmt->fetchAll(); // Возвращаем массив данных
    }
    public function getParametr($displayName, $tableName){
        $table = $this->getTable($tableName);
        $stmt = $this->pdo->prepare("SELECT * FROM $tableName WHERE displayName = :displayName"); // Подготовка запроса
        $stmt->execute(['displayName' => $displayName]); // Выполнение запроса с подстановкой значения
        return $stmt->fetch(); // Получаем одну строку
    }
    public function register($displayName, $password, $login){
        $tmt = $this->pdo->prepare("INSERT INTO `users` (`displayName`, `password_hash`, `role`, `name`)
                                VALUES (:displayName, :password_hash, :role, :name)");
  $result=$tmt->execute([
            'displayName' => $displayName,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'role' => "gost",    // Здесь передаем строку "gost"
            'name' => $login     // Здесь передаем строку "name"
        ]);
  return $result;
    }
}
?>
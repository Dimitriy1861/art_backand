<?php
$host = "dimitrtj.beget.tech"; // Или IP сервера БД
$dbname = "dimitrtj_pictor";
$username = "dimitrtj_pictor";
$password = "Edgy2375";

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
?>

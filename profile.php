<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
echo "👋 Добро пожаловать, " . htmlspecialchars($_SESSION["username"]);
?>
<a href="logout.php">Выйти</a>


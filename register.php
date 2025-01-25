<?php
session_start();
include_once "db.php"; // Подключаем БД

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Хешируем пароль
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
    if ($stmt->execute([$username, $passwordHash])) {
        echo "✅ Регистрация успешна!";
    } else {
        echo "❌ Ошибка регистрации!";
    }
}
?>
<form method="POST">
    <input type="text" name="username" placeholder="Логинsasd" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Зарегистрироваться</button>
</form>


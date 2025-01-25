
<?php
session_start();
require_once "db.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Ищем пользователя в БД
    $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password_hash"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $username;
        header("Location: profile.php"); // Перенаправление в личный кабинет
        exit();
    } else {
        echo "❌ Неверный логин или пароль!";
    }
}
?>
<form method="POST">
    <input type="text" name="username" placeholder="Логинasdasd" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Войти</button>
</form>

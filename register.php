<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $connect = mysqli_connect($host, $user, $pass, $db);
    if (!$connect) {
        die("Ошибка подключения: " . mysqli_connect_error());
    }

    $username = $_POST["name"];
    $password = $_POST["pass"];
    $full_name = $_POST["full_name"];
    $role = $_POST["role"];

    $checkQuery = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connect, $checkQuery);
    if (mysqli_num_rows($result) > 0) {
        echo "<div class='forma'><h1>Пользователь с таким именем уже существует</h1></div>";
        echo "<div class='forma'><a href='register.php' class='btn4'><p>Назад</p></a></div>";
        exit;
    }

    $sql = "INSERT INTO users (username, password, full_name_inspector, role) VALUES ('$username', '$password', '$full_name', '$role')";

    if (mysqli_query($connect, $sql)) {
        session_start();
        $_SESSION["username"] = $username;
        if ($role == "admin") {
            header("Location: role/admin.php");
        } elseif ($role == "inspector") {
            header("Location: role/inspector.php");
        } elseif ($role == "cashier") {
            header("Location: role/cashier.php");
        } elseif ($role == "extra") {
            header("Location: role/extra.php");
        } else {
            header("Location: index2.php");
        }
        exit;
    } else {
        echo "Ошибка: " . $sql . "<br>" . mysqli_error($connect);
    }
    mysqli_close($connect);
}
?>
    <section class="header_container">
        <div class="container">
            <div class="btn">
                <a href="vxod.php" class="btn2">Вход</a>
            </div>
        </div>
    </section>
    
    <section>
        <form action="register.php" method="post">
            <div class="forma">
                <h1>Регистрация</h1>
                <p>Для регистрации введите имя пользователя и пароль</p>

                <label for="name"> Логин:</label>
                <input type="text" placeholder="Введите имя" id="name" name="name" required>

                <label for="pass">Пароль:</label>
                <input type="password" placeholder="Введите пароль" id="pass" name="pass" required>
                
                <label for="full_name">ФИО:</label>
                <input type="text" placeholder="Введите ФИО" id="full_name" name="full_name" required>

                <label for="role">Выберите вашу роль:</label>
                <select name="role" id="role">
                    <option value="inspector">Инспектор</option>
                    <option value="admin">Администратор</option>
                    <option value="cashier">Кассир</option>
                    <option value="extra">Статист</option>
                </select>

                <button type="submit" class="btn2"><p>Регистрация</p></button>
            </div>

            <div class="signin">
                <p>Уже зарегистрированы? <a href="vxod.php">Вход</a></p>
            </div>
            <div class="container">
                <a href="index.php" class="btn4">Назад</a>
            </div>
        </form>
    </section>
</body>
</html>
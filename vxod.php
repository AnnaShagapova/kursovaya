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
        require_once ("config.php");
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $connect = mysqli_connect($host, $user, $pass, $db);
            if (!$connect) {
                die("Ошибка подключения: " . mysqli_connect_error());
            }
        
            $username = $_POST["name"];
            $password = $_POST["pass"];

            $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";   
           
            $result = mysqli_query($connect, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $role = $row["role"];
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
                    // header("Location: index2.php");
                echo "Ошибка";
                }
                exit;
            } else {
                echo "Неверные имя пользователя или пароль.";
            }        
            mysqli_close($connect);
        }
    ?>
    <section class="header_container">
       <div class="container">
            <div class="btn">
                <a href="register.php" class="btn1">Регистрация</a>
            </div>
       </div>
    </section>
    <form action="vxod.php" method="post">
        <div class="forma">
            <h1>Вход</h1>
            <p>Для входа введите имя пользователя и пароль</p>
        
            <label for="name">Логин:</label>
            <input type="text" placeholder="Введите имя" id="name" name="name" required>

            <label for="pass">Пароль:</label>
            <input type="password" placeholder="Введите пароль" id="pass" name="pass" required>

            <button type="submit" class="btn2"><p>Вход</p></button>
        </div>
        <div class="signin">
            <p>Еще не зарегистрированы? <a href="register.php">Регистрация</a></p>
        </div>

        <div class="container">
            <a href="index.php" class="btn4">Назад</a>
        </div>
    </form>
</body>
</html>
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
        session_start();
        echo "Привет, " . $_SESSION["username"] . "!";
        echo "<br>";
        echo "Это страница add_personal.php";

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
                exit;
            }       
            $sql = "INSERT INTO users (username, password, full_name_inspector, role) VALUES ('$username', '$password', '$full_name', '$role')";
            
            if (mysqli_query($connect, $sql)) {
                echo "<br>Сотрудник успешно добавлен";
            }
            mysqli_close($connect);
        }
        ?>  
            <section>
                <form action="add_personal.php" method="post">
                    <div class="forma">
                        <h2>Для добавления сотрудника заполните поля</h2>
        
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
        
                        <button type="submit" class="btn2"><p>Отправить</p></button>
                    </div>
                </form>
            </section>
</body>
</html>
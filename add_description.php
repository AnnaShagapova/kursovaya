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
    echo "Это страница add_description.php";

        require_once("config.php");
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $connect = mysqli_connect($host, $user, $pass, $db);
            if (!$connect) {
                die("Ошибка подключения: " . mysqli_connect_error());
            }
            $rule_name  = $_POST["rule_name"];
            // $rule_point = $_POST["rule_point"];
            $rule_description = $_POST["rule_description"];
            $fine_amount = $_POST["fine_amount"];
            
            $sql = "INSERT INTO rules (rule_name, rule_description, fine_amount) VALUES ('$rule_name', '$rule_description', '$fine_amount')";

            if (mysqli_query($connect, $sql)) {
                echo "Запись успешно добавлена";
            } else {
                echo "Ошибка: " . $sql . "<br>" . mysqli_error($connect);
            }
            mysqli_close($connect);
        }
    ?>

    <form method="post" action="add_description.php">
        <h1>Заполните информацию о правонарушении</h1>
        <label for="rule_name">Название правонарушения:</label>
        <input type="text" id="rule_name" name="rule_name"><br>

        <label for="rule_description">Описание правонарушения:</label>
        <textarea id="rule_description" name="rule_description"></textarea><br>
        
        <label for="fine_amount">Сумма штрафа:</label>
        <input type="text" id="fine_amount" name="fine_amount"><br>

        <button type="submit">Отправить</button>

</body>
</html>
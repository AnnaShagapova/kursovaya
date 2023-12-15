<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="add_protocol.php" method="post">
        <label for="car_number">Введите номер машины:</label>
        <input type="text" name="car_number" id="car_number">
        <br>
        <button type="submit">Проверить</button>
    </form>

    <?php
    session_start();
    echo "Привет, " . $_SESSION["username"] . "!";
    echo "<br>";
    echo "Это страница add_protocol.php<br>";

    require_once("config.php");    
    $connect = mysqli_connect($host, $user, $pass, $db);
    if (!$connect) {
        die("Ошибка подключения: " . mysqli_connect_error());
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $car_number = $_POST["car_number"];
        
        $sql = "SELECT * FROM offender WHERE car_number = '$car_number'";
        $result = mysqli_query($connect, $sql);

        if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo "Инспектор: " . $row['full_name_inspector'] . "<br>";
                echo "Имя владельца: " . $row['full_name'] . "<br>";
                echo "Номер водительского удостоверения: " . $row['driver_license_number'] . "<br>";
                echo "Марка автомобиля: " . $row['car_make'] . "<br>";
                echo "Номер машины: " . $row['car_number'] . "<br>";
                echo "Описание нарушения: " . $row['rule_description'] . "<br>";

                $offender_id = $row['offender_id'];

                $sql = "SELECT * FROM protocol WHERE offender_id = '$offender_id'";
                $result = mysqli_query($connect, $sql);

                    if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo "Дата составления протокола: " . $row['violation_date'] . "<br>";
                    echo "Место составления протокола: " . $row['location'] . "<br>";
                    echo "Заметки инспектора: " . $row['inspector_notes'] . "<br>";
                } else {
                    echo "Не получилось вывести данные из таблицы protocol";
                }  
        } else {
            echo "Нет такого номера в бд";
        }
        mysqli_close($connect);
    }
    ?>
</body>
</html>
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
        echo "Это страница add_offender.php";

        require_once("config.php");
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $connect = mysqli_connect($host, $user, $pass, $db);
            if (!$connect) {
                die("Ошибка подключения: " . mysqli_connect_error());
            }
          
            $full_name = $_POST["full_name"];
            $driver_license_number = $_POST["driver_license_number"];
            $car_make = $_POST["car_make"];
            $car_number = $_POST["car_number"];
            $rule_description = $_POST["rule_description"];

            $violation_date = $_POST["violation_date"];
            $location = $_POST["location"];
            $inspector_notes = $_POST["inspector_notes"];
          
            $sql = "INSERT INTO offender (full_name, driver_license_number, car_make, car_number, rule_description) VALUES ('$full_name', '$driver_license_number', '$car_make', '$car_number', '$rule_description')";

            $sql2 = "INSERT INTO protocol (offender_id, violation_date, location, inspector_notes) VALUES ((SELECT MAX(offender_id) FROM offender), '$violation_date', '$location', '$inspector_notes')";

            if (mysqli_query($connect, $sql)) {
                echo "Запись успешно добавлена";
            } else {
                echo "Ошибка: " . $sql . "<br>" . mysqli_error($connect);
            }
            if (mysqli_query($connect, $sql2)) {
                echo "Запись успешно добавлена";
            } else {
                echo "Ошибка: " . $sql2 . "<br>" . mysqli_error($connect);
            }

            $username = $_SESSION["username"];
            $check_username_query = "SELECT * FROM users WHERE username = '$username'";
            $check_username_result = mysqli_query($connect, $check_username_query);
        
            if (mysqli_num_rows($check_username_result) > 0) {
                $update_full_name_inspector_query = "UPDATE offender SET full_name_inspector = (SELECT full_name_inspector FROM users WHERE username = '$username') WHERE full_name = '$full_name' AND driver_license_number = '$driver_license_number'";
                mysqli_query($connect, $update_full_name_inspector_query);
            } else {
                echo "Ошибка: Неверное имя пользователя";
            }
            mysqli_close($connect);
        }
    ?>
   <form method="post" action="add_offender.php">
    <h1>Заполните информацию о правонарушителе</h1>

    <label for="full_name">ФИО:</label>
    <input type="text" id="full_name" name="full_name"><br>

    <label for="driver_license_number">Номер водительского удостоверения:</label>
    <input type="text" id="driver_license_number" name="driver_license_number"><br>

    <label for="car_make">Марка машины:</label>
    <input type="text" id="car_make" name="car_make"><br>

    <label for="car_number">Номер машины:</label>
    <input type="text" id="car_number" name="car_number"><br>

    <label for="rule_description">Описание правонарушения:</label>
    <select name="rule_description">
        <?php
        require_once("config.php");
        $connect = mysqli_connect($host, $user, $pass, $db);
        if (!$connect) {
            die("Ошибка подключения: " . mysqli_connect_error());
        }
        $sql = "SELECT rule_description FROM rules";
        $result = mysqli_query($connect, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $rule_description = $row['rule_description'];
            echo "<option value='$rule_description'>$rule_description</option>";
        }
        ?>
    </select><br>
    <label for="violation_date">Дата нарушения:</label>
    <input type="date" id="violation_date" name="violation_date"><br>

    <label for="location">Место нарушения:</label>
    <input type="text" id="location" name="location"><br>

    <label for="inspector_notes">Примечания инспектора:</label>
    <textarea id="inspector_notes" name="inspector_notes"></textarea><br>

    <input type="submit" value="Отправить">
</form>
</body>
</html>
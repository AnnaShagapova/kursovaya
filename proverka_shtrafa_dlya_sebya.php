<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="proverka_shtrafa_dlya_sebya.php" method="post">
        <label for="car_number">Введите номер машины:</label>
        <input type="text" name="car_number" id="car_number">
        <br>
        <label for="driver_license_number">Или введите номер водительского удостоверения:</label>
        <input type="text" name="driver_license_number" id="driver_license_number">
        <br>
        <button type="submit">Проверить</button>
    </form>
    <?php
    require_once("config.php");
    $connect = mysqli_connect($host, $user, $pass, $db);
    if (!$connect) {
        die("Ошибка подключения: " . mysqli_connect_error());
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $car_number = $_POST["car_number"];
        $driver_license_number = $_POST["driver_license_number"];
        
    $sql = "SELECT * FROM offender WHERE car_number = '$car_number' OR driver_license_number = '$driver_license_number'";

    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo "ФИО нарушителя: " . $row['full_name'] . "<br>";
        echo "Номер машины: " . $row['car_number'] . "<br>";
        echo "Марка машины: " . $row['car_make'] . "<br>";
        echo "Номер водительского удостоверения: " . $row['driver_license_number'] . "<br>";
        echo "Нарушение: " . $row['rule_description'] . "<br>";

        $rule_description = $row['rule_description'];
        $rule_sql = "SELECT fine_amount FROM rules WHERE rule_description = '$rule_description'";
        $rule_result = mysqli_query($connect, $rule_sql);

        if (mysqli_num_rows($rule_result) > 0) {
            $rule_row = mysqli_fetch_assoc($rule_result);
            echo "Сумма штрафа: " . $rule_row['fine_amount'] . "<br>";
            echo "<a href='oplata.php'>Оплатить штраф</a>";       
        }
    } else {
        echo "Нарушение не найдено.";
    }
    
    mysqli_close($connect);
}
    ?>

</body>
</html>
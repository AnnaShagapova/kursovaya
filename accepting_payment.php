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
echo "Это страница accepting_payment.php<br>";

require_once("config.php");

$connect = mysqli_connect($host, $user, $pass, $db);
if (!$connect) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

$sql = "SELECT fp.offender_id, fp.payment_amount, o.full_name
        FROM fine_payment fp
        LEFT JOIN offender o ON fp.offender_id = o.offender_id";

$result = $connect->query($sql);

if ($result->num_rows > 0) {

    $total_payment_amount = 0; 
    while ($row = $result->fetch_assoc()) {
        $payment_amount = $row["payment_amount"];
        $full_name = $row["full_name"];

        echo "<br>Сумма оплаты: " . $payment_amount. "<br>";

        if ($full_name) {
            echo "ФИО водителя: " . $full_name;
        }

        echo "<br>";

        $total_payment_amount += $payment_amount; 
    }

    echo "<br>Общая сумма оплат: " . $total_payment_amount; 
} else {
    echo "Нет результатов.";
}

mysqli_close($connect);
?>
</body>
</html>
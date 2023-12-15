<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="oplata.php" method="post">
        <label for="car_number">Введите номер машины:</label>
        <input type="text" name="car_number" id="car_number">
        <br>
        <label for="driver_license_number">Или введите номер водительского удостоверения:</label>
        <input type="text" name="driver_license_number" id="driver_license_number">
        <br>
        <label for="payment_amount">Введите сумму оплаты</label>
        <input type="text" name="payment_amount" id="payment_amount">
        <button type="submit">Оплатить</button>
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

        $rule_description = $row['rule_description'];
        $rule_sql = "SELECT fine_amount FROM rules WHERE rule_description = '$rule_description'";
        $rule_result = mysqli_query($connect, $rule_sql);
        
        if (mysqli_num_rows($rule_result) > 0) {
            $rule_row = mysqli_fetch_assoc($rule_result);
            
            $offender_id = $row['offender_id'];
            $insert_query = "INSERT INTO fine_payment (offender_id) VALUES ('$offender_id')";
            mysqli_query($connect, $insert_query);
            $payment_id = mysqli_insert_id($connect);

            $rule_description = $row['rule_description'];
            $rule_id_query = "SELECT rule_id FROM rules WHERE rule_description = '$rule_description'";
            $rule_id_result = mysqli_query($connect, $rule_id_query);
            if(mysqli_num_rows($rule_id_result) > 0) {
                $rule_id_row = mysqli_fetch_assoc($rule_id_result);
                $rule_id = $rule_id_row['rule_id'];
                $update_query = "UPDATE fine_payment SET rule_id = '$rule_id' WHERE payment_id = '$payment_id'";
                mysqli_query($connect, $update_query);
            }
            $payment_date = date('Y-m-d');
            $update_date_query = "UPDATE fine_payment SET payment_date = '$payment_date' WHERE payment_id = '$payment_id'";
            mysqli_query($connect, $update_date_query);

            if(isset($_POST["payment_amount"])) {
            $payment_amount = $_POST["payment_amount"];

            $check_payment_query = "SELECT fine_amount FROM rules WHERE rule_id = '$rule_id'";
            $check_payment_result = mysqli_query($connect, $check_payment_query);
            
            if(mysqli_num_rows($check_payment_result) > 0) {
                $row = mysqli_fetch_assoc($check_payment_result);
                $fine_amount = $row['fine_amount'];
                if($payment_amount == $fine_amount) {
                    echo "Штраф оплачен";  
                    echo "<br>";
                    
                    $sql = "SELECT * FROM offender WHERE offender_id = '$offender_id'";
                    $result = mysqli_query($connect, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $full_name = $row['full_name'];
                        $rule_description = $row['rule_description'];

                    }
                    
                    
                    echo "<a href='check.php'>Квитанция об оплате</a>";
                    $update_payment_query = "UPDATE fine_payment SET payment_amount = '$payment_amount' WHERE payment_id = '$payment_id'";
                    mysqli_query($connect, $update_payment_query);
                    
                    if(isset($_POST["offender_id"])) {
                        $offender_id = $row['offender_id'];             
                    }
                    // не удаллять данные из таблицы protocol, а заменить их значениями NULL
                    $update_protocol_query = "UPDATE protocol SET location = NULL, inspector_notes = NULL WHERE offender_id = '$offender_id'";
                        mysqli_query($connect, $update_protocol_query);
                    $clear_offender_query = "UPDATE offender SET driver_license_number = NULL, car_number = NULL WHERE offender_id = '$offender_id'";
                        mysqli_query($connect, $clear_offender_query);  
                    
                    $sql2  = "SELECT * FROM fine_payment WHERE offender_id = '$offender_id'";
                    $result2 = mysqli_query($connect, $sql2);
                    if(mysqli_num_rows($result2) > 0) {   
                        $row2 = mysqli_fetch_assoc($result2);
                        $payment_amount = $row2['payment_amount'];
                        $payment_date = $row2['payment_date'];
                    }
    
                    $str = fopen("check.txt", "w") or die("не удалось открыть файл");
    
                    $name_rule = "Название правила: ". $rule_description."<br>";
                    $fname = "ФИО водителя: ". $full_name."<br>";
                    $amount = "Сумма оплаты: ". $payment_amount."<br>";
                    $date = "Дата оплаты: ". $payment_date."<br>";
    
                    fwrite($str, $name_rule ."\n");
                    fwrite($str, $fname."\n");
                    fwrite($str, $amount."\n");
                    fwrite($str, $date."\n");
    
                    fclose($str);
                } else {
                    echo "Штраф не оплачен";
                }
            }

        }

        } else {
            echo "Сумма штрафа не найдена.";
        }
    } else {
        echo "Нарушение не найдено.";
    }
    
    mysqli_close($connect);
}
    ?>

</body>
</html>
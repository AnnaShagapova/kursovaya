<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
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

        $payment_amount = $_POST["payment_amount"];

        $check_payment_query = "SELECT fine_amount FROM rules WHERE rule_id = '$rule_id'";
        $check_payment_result = mysqli_query($connect, $check_payment_query);
        
        if(mysqli_num_rows($check_payment_result) > 0) {
            $row = mysqli_fetch_assoc($check_payment_result);
            $fine_amount = $row['fine_amount'];
            if($payment_amount == $fine_amount) {
                echo "Штраф оплачен";
                $update_payment_query = "UPDATE fine_payment SET payment_amount = '$payment_amount' WHERE payment_id = '$payment_id'";
                mysqli_query($connect, $update_payment_query);
            } else {
                echo "Штраф не оплачен";
            }
        }

        // if($_SERVER["REQUEST_METHOD"] == "POST") {
        //     $payment_amount = $_POST["payment_amount"];
        //     if($payment_amount == $fine_amount) {
        //         $check_payment_query = "SELECT fine_amount FROM rules WHERE rule_id = '$rule_id' AND payment_id = '$payment_id'";
        //         $check_payment_result = mysqli_query($connect, $check_payment_query);
        //         if(mysqli_num_rows($check_payment_result) > 0) {
        //             $row = mysqli_fetch_assoc($check_payment_result);
        //             $fine_amount = $row['fine_amount'];

        //             if($payment_amount == $fine_amount) {
        //                 echo "Штраф оплачен";
        //             } else {
        //                 echo "Штраф не оплачен";
        //             }
        //         } else {
        //             echo "недостаточно средств, попробуйте еще раз";
        //         }
        //     }
        // }

    } else {
        echo "Сумма штрафа не найдена.";
    }
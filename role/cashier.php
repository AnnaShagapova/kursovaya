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
    echo "Это страница cashier.php";
?>
<section class="header_container">
       <div class="container">
            <div class="menu">  
                    <div class="btn"> 
                        <a  href="../accepting_payment.php" class="btn2">Прием оплаты</a><br>
                    </div>  
            </div>
       </div>
    </section>
</body>
</html>
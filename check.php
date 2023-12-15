<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<section class="header_container">
       <div class="container">
            <div class="menu">  
                    <p>Название ГИБДД: МРЭО ГИБДД ГУ МВД России по Челябинской области</p>
                    <p>КПП: 280701001</p>
                    <p>ИНН получателя: 2807011893</p>
                    <p>Код ОКТНО: 10730000</p>
                    <p>Номер счета: 40101810000000010003</p>
                    <p>БИК: 044030653</p>
                    <p>Название банка получателя: "Публичное акционерное общество «Сбербанк России»"</p>
            </div>
       </div>
    </section>
    <?php

    require_once("config.php");    
    $connect = mysqli_connect($host, $user, $pass, $db);
    if (!$connect) {
        die("Ошибка подключения: " . mysqli_connect_error());
    }


    $filename = 'check.txt';
    $file_contents = file_get_contents($filename);

    echo $file_contents;
   
    ?>
</body>
</html>
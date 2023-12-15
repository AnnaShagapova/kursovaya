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
                require_once ("config.php");
                    $connect = mysqli_connect($host, $user, $pass, $db);
                        if(!$connect) {
                        die();
                     }
            ?>
    <section class="header_container">
       <div class="container">
            <div class="menu">  
                    <div class="btn"> 
                        <a  href="vxod.php" class="btn2">Вход</a><br>
                        <a href="register.php" class="btn1">Регистрация</a><br>
                        <a href="proverka_shtrafa_dlya_sebya.php" class="btn1">Проверка штрафов</a>
                    </div>  
            </div>
       </div>
    </section>
</body>
</html>
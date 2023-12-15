<?php
 session_start();
 echo "Привет, " . $_SESSION["username"] . "!";
 echo "<br>";
 echo "Это страница index2.php";
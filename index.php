<?php
 $path = $_SERVER["REQUEST_URI"];

 switch ($path) {
    case "/":
        require __DIR__."/template/login.php";
        break;
    case "/login":
        require __DIR__."/template/login.php";
        break;
    case "/inscription":
        require __DIR__."/template/inscription.php";
        break;
    default:
        echo "404";
        break;
    }

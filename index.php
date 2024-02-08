<?php
// fichier index.php

require 'Classes/autoloader.php'; 
Autoloader::register(); 




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
    case "/accueil": 
        require __DIR__."/template/Accueil.php";
        break;
    case "/accueil_admin":
        require __DIR__."/template/accueil_adm.php";
    default:
        echo "404";
        break;
    }

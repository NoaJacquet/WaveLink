<?php
// fichier index.php

require 'Classes/autoloader.php'; 
Autoloader::register(); 

$path = strtolower($_SERVER["REQUEST_URI"]);

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
        break;
    case strpos($path, "/album_detail") !== false:
        // Récupérer l'ID de l'album à partir de la requête
        $albumId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
        // Vérifier si l'ID est valide (vous pouvez ajouter d'autres vérifications selon vos besoins)
        if ($albumId > 0) {
            // Inclure le fichier du contrôleur pour la page album-detail
            require __DIR__."/template/album_detail.php";
        } else {
            // Gérer le cas où l'ID n'est pas valide
            echo "ID d'album non valide";
        }
        break;
    case strpos($path, "/artiste_detail") !== false:
        // Récupérer l'ID de l'artiste à partir de la requête
        $artisteId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
        // Vérifier si l'ID est valide (vous pouvez ajouter d'autres vérifications selon vos besoins)
        if ($artisteId > 0) {
            // Inclure le fichier du contrôleur pour la page artiste-detail
            require __DIR__."/template/artiste_detail.php";
        } else {
            // Gérer le cas où l'ID n'est pas valide
            echo "ID d'artiste non valide";
        }
        break;
    case strpos($path, "/genre_detail") !== false:
        // Récupérer l'ID de l'genre à partir de la requête
        $genreId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
        // Vérifier si l'ID est valide (vous pouvez ajouter d'autres vérifications selon vos besoins)
        if ($genreId > 0) {
            // Inclure le fichier du contrôleur pour la page genre-detail
            require __DIR__."/template/genre_detail.php";
        } else {
            // Gérer le cas où l'ID n'est pas valide
            echo "ID d'genre non valide";
        }
        break;
    default:
        echo "404";
        break;
}
?>

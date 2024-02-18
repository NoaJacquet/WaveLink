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
    case strpos($path, "/accueil_user") !== false:
        // Récupérer l'ID de l'genre à partir de la requête
        $userId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($userId > 0) {
            require __DIR__."/template/Accueil.php";
        } else {
            echo "ID du user non valide";
        }
        break;
    case "/accueil_admin":
        require __DIR__."/template/accueil_adm.php";
        break;
    case "/add-artiste":
        require __DIR__."/template/add_artistes.php";
        break;
    case "/add-genre":
        require __DIR__."/template/add_genre.php";
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
    case strpos($path, "/genre") !== false:
        // Récupérer l'ID du genre à partir de la requête
        $genreId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $userId = isset($_GET['userId']) ? intval($_GET['userId']) : 0;
    
        // Vérifier si l'ID est valide (vous pouvez ajouter d'autres vérifications selon vos besoins)
        if ($genreId > 0 && $userId>0) {
            // Inclure le fichier du contrôleur pour la page Genre
            require __DIR__."/template/Genre.php";
        } else {
            // Gérer le cas où l'ID n'est pas valide
            echo "ID de genre non valide";
        }
        break;
    case strpos($path, "/add-album") !== false:
        // Récupérer l'ID de l'album à partir de la requête
        $artisteId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
        // Vérifier si l'ID est valide (vous pouvez ajouter d'autres vérifications selon vos besoins)
        if ($artisteId > 0) {
            // Inclure le fichier du contrôleur pour la page album-detail
            require __DIR__."/template/add_album.php";
        } else {
            // Gérer le cas où l'ID n'est pas valide
            echo "ID d'artiste non valide";
        }
        break;
    case strpos($path, "/add-musique") !== false:
        // Récupérer l'ID de l'album à partir de la requête
        $artisteId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
        // Vérifier si l'ID est valide (vous pouvez ajouter d'autres vérifications selon vos besoins)
        if ($artisteId > 0) {
            // Inclure le fichier du contrôleur pour la page album-detail
            require __DIR__."/template/add_musique.php";
        } else {
            // Gérer le cas où l'ID n'est pas valide
            echo "ID d'artiste non valide";
        }
        break;
    case strpos($path, "/detail-playlist") !== false:
        // Récupérer l'ID de l'album à partir de la requête
        $playlistId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $userId = isset($_GET['userId']) ? intval($_GET['userId']) : 0;
        // Vérifier si l'ID est valide (vous pouvez ajouter d'autres vérifications selon vos besoins)
        if ($playlistId > 0 && $userId > 0) {
            // Inclure le fichier du contrôleur pour la page album-detail
            require __DIR__."/template/PlaylistDetail.php";
        } else {
            // Gérer le cas où l'ID n'est pas valide
            echo "ID de playlist non valide";
        }
        break;
    case strpos($path, "/album_detail_admin") !== false:
        // Récupérer l'ID de l'album à partir de la requête
        $albumId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
        // Vérifier si l'ID est valide (vous pouvez ajouter d'autres vérifications selon vos besoins)
        if ($albumId > 0) {
            // Inclure le fichier du contrôleur pour la page album-detail
            require __DIR__."/template/album_detail_admin.php";
        } else {
            // Gérer le cas où l'ID n'est pas valide
            echo "ID d'album non valide";
        }
        break;
    case strpos($path, "/album_detail") !== false:
        // Récupérer l'ID de l'album à partir de la requête
        $musiqueId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $userId = isset($_GET['userId']) ? intval($_GET['userId']) : 0;
    
        // Vérifier si l'ID est valide (vous pouvez ajouter d'autres vérifications selon vos besoins)
        if ($musiqueId > 0 && $userId>0) {
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
    case strpos($path, "/add-playlist") !== false:
        // Récupérer l'ID de l'genre à partir de la requête
        $userId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
        if ($userId > 0) {
            require __DIR__."/template/add_playlist.php";
        } else {
            echo "ID du user non valide";
        }
        break;
    default:
        echo "404";
        break;

}
?>


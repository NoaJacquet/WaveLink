<?php 

use View\Header;
$header = new Header();

use View\Playlist;
$playlist = new Playlist();


use modele_bd\Connexion;
use modele_bd\MusiqueBD;
use modele_bd\AlbumBD;

$connexion = new Connexion();
$connexion->connexionBD();

$musiqueManager = new MusiqueBD($connexion->getPDO());
$albumManager = new AlbumBD($connexion->getPDO());


$musiques = $musiqueManager->getMusiquesByAlbumId($musiqueId);

use View\Footer;
$footer = new Footer();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel='stylesheet' href='../style/Accueil.css'>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://unpkg.com/htmx.org@latest/dist/htmx.js"></script>
</head>
<body>
    <?php
    echo $header->renderH($userId);
    ?>
    <main>
    <?php
    echo $playlist->renderPlaylist($userId);
    ?>
    <div class="slider-container">
    <div id='main'>
            <?php
            echo "<h1>".$albumManager->getAlbumById($musiqueId)->getTitreAlbum()."</h1>";

            foreach($musiques as $key => $musique){
                echo "<li>";
                echo "<div id='son'>";
                echo "<img src='/images/".$albumManager->getAlbumById($musiqueId)->getImgAlbum()."' alt=''>";
                echo "<div>";
                echo "<p>".$musique->getNomMusique()."</p>";
                echo "</div>";
                echo "</div>";
                echo "</li>";
            }
            ?> 
    </div>
    </div>
       </main>
    <?php
    echo $footer->render();
    ?>
</div>
</body>
<script src="../style/musicLector.js"></script>
</html>
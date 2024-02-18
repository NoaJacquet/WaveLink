<?php

use View\Header;
$header = new Header();

use View\Playlist;
$playlist = new Playlist();

use modele_bd\Connexion;
use modele_bd\GenreBD;   
$connexion = new Connexion();
$connexion->connexionBD();  
$genreManager = new GenreBD($connexion->getPDO());
$albums = $genreManager->getAlbumByIdGenre($genreId);

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
        <div id='main'>

        <h2>Album de genre :</h2>
            <?php       
                    foreach($albums as $key => $album){
                        echo "<li>";
                        echo '<a href="/album_detail?id=' . $album->getIdAlbum() . '&userId=' . $userId . '">';
                        echo "<div id='detail-playlist'>";
                        echo "<img src='../images/".$album->getImgAlbum()."' alt=''>";
                        echo "<p>".$album->getTitreAlbum()."</p>";
                        echo "</div>";
                        echo "</a>";
                        echo "</li>";
                    }
            ?>
        </div>
    </main>
    <?php
        echo $footer->render();
        ?>
</body>
<script src="../style/musicLector.js"></script>
</html>
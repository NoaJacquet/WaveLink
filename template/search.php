<?php
    use modele_bd\Connexion;
    use modele_bd\AlbumBD;
    use modele_bd\ArtistesBD;
    use View\AlbumView;
    use View\Header;
    use View\ArtisteView;
    use modele_bd\GenreBD;
    use View\GenreView;
    use View\MusiqueView;
    use modele_bd\MusiqueBD;
    use View\Playlist;

    $playlistView = new Playlist();


    $header = new Header();

    $connexion = new Connexion();
    $connexion->connexionBD();

    $albumBD = new AlbumBD($connexion->getPDO());

    $artisteBD = new ArtistesBD($connexion->getPDO());

    $albums = $albumBD->getAllAlbumsBis($m);
    $artistes = $artisteBD->getAllArtistsBis($m);

    $genreBD = new GenreBD($connexion->getPDO());
    $genres = $genreBD->getAllGenresBis($m);

    $musiqueBD = new MusiqueBD( $connexion->getPDO());
    $musiques = $musiqueBD->getAllMusiquesBis($m);

    use modele_bd\RenfermerBD;
    $renfermerBD = new RenfermerBD($connexion->getPDO());
    use modele_bd\PlaylistBD;
    $playlistBD = new PlaylistBD($connexion->getPDO());
    use View\Footer;
    $footer = new Footer();




?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel='stylesheet' href='../style/Accueil_bd.css'>
    <link rel='stylesheet' href='../style/Accueil.css'>
    <link rel='stylesheet' href='../style/detail.css'>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
</head>
<body>
    <?php
    echo $header->renderH($userId);
    ?>
    <main>
    <?php

    echo $playlistView->renderPlaylist($userId);
    ?>
        <div id='main'>
            <div class="top">
                <h2>Musique</h2>

            </div>

            <div class="musique">
                <?php
                MusiqueView::renderMusiques($musiques,$albumBD, $userId,$artisteBD,$renfermerBD,$playlistBD)
                ?>

            </div>

            <div class="top">
                    <h2>Album</h2>

            </div>  
            
            <div class="album" >
                <?php
                AlbumView::renderAlbumsBis($albums, $artisteBD,count($albums),$userId);
                ?>
            </div>

            <div class="top">
                <h2>Artistes</h2>
            </div>  

            <div class="artiste" >
                <?php
                ArtisteView::renderArtistesBis($artistes,count($artistes),$userId);
                ?>
            </div>

            <div class="top">
                <h2>Genres</h2>
            </div>  
            <div class="genre">
                <?php
                GenreView::renderGenresBis($genres,count($genres),$userId);
                ?>
            </div>

        </div>
    </main>
    <?php

    echo $footer->render();
    ?>
</body>
<script src="../style/musicLector.js"></script>



</html>
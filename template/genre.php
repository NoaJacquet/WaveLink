<?php

use View\Header;
$header = new Header();

use View\Playlist;
$playlist = new Playlist();

use modele_bd\Connexion;
use modele_bd\GenreBD;   
use modele_bd\AlbumBD;
use modele_bd\ArtistesBD;
use View\AlbumView;
$connexion = new Connexion();
$connexion->connexionBD();  
$albumBD = new AlbumBD($connexion->getPDO());
$artisteBD = new ArtistesBD($connexion->getPDO());
$genreBD = new GenreBD($connexion->getPDO());

$albums = $genreBD->getAlbumByIdGenre($genreId);

use View\ArtisteView;

$artistes = $genreBD->getArtistesByIdGenre($genreId);


use View\Footer;
$footer = new Footer();


$nbrAlbum = $albumBD->countAlbums();

$nbrArtistes = $artisteBD->countArtistes();


?>


</htm<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel='stylesheet' href='../style/Accueil_bd.css'>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
</head>
<body>
    <?php
    echo $header->renderH($userId);
    ?>
    <main>
        <div id='main'>
            <div class="top">
                    <h2>Album</h2>
                    <p id='tout-voir'>Tout voir</p>
                    <p id='voir-moins' style="display:none">Voir moins</p>
            </div>  
            <div class="album"  >
                
                <?php

                AlbumView::renderAlbumsBis($albums, $artisteBD, 6,$userId);

                ?>

            </div>
            <div class="album2" style="display: none;">
                
                <?php
                
                AlbumView::renderAlbumsBis($albums, $artisteBD, $nbrAlbum,$userId);

                ?>

            </div>
            <div class="top">
                <h2>Artistes</h2>
                <p id='tout-voir-artiste'>Tout voir</p>
                <p id='voir-moins-artiste' style="display:none">Voir moins</p>
                <a href='/add-artiste'>Ajouter un Artistes</a>
            </div>  

            <div class="artiste">
                <?php
                ArtisteView::renderArtistesBis($artistes,6, $userId);
                ?>
            </div>
            <div class="artiste2" style="display: none;">
                <?php
                ArtisteView::renderArtistesBis($artistes,$nbrArtistes,$userId);
                ?>
            </div>
        </div>
    </main>
    <?php
    echo $footer->render();
    ?>
</body>
<script src="../style/musicLector.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Sélectionner les éléments DOM
        var toutVoirButtonAlbum = document.getElementById('tout-voir');
        var voirMoinsButtonAlbum = document.getElementById('voir-moins');
        var albumContainer = document.querySelector('.album');
        var album2Container = document.querySelector('.album2');

        var toutVoirButtonArtiste = document.getElementById('tout-voir-artiste');
        var voirMoinsButtonArtiste = document.getElementById('voir-moins-artiste');
        var artisteContainer = document.querySelector('.artiste');
        var artiste2Container = document.querySelector('.artiste2');

        var toutVoirButtonGenre = document.getElementById('tout-voir-genre');
        var voirMoinsButtonGenre = document.getElementById('voir-moins-genre');
        var genreContainer = document.querySelector('.genre');
        var genre2Container = document.querySelector('.genre2');

        // Fonction pour gérer le basculement
        function toggleContainers(toutVoirButton, voirMoinsButton, container1, container2) {
            toutVoirButton.addEventListener('click', function () {
                container2.style.display = 'flex';
                voirMoinsButton.style.display = 'flex';
                voirMoinsButton.style.alignItems = 'center'; // Utilisation de alignItems
                container1.style.display = 'none';
                toutVoirButton.style.display = 'none';
            });

            voirMoinsButton.addEventListener('click', function () {
                voirMoinsButton.style.display = 'none';
                container2.style.display = 'none';
                container1.style.display = 'flex';
                toutVoirButton.style.display = 'flex';
                toutVoirButton.style.alignItems = 'center'; // Utilisation de alignItems
            });
        }



        // Appliquer la logique pour chaque section
        toggleContainers(toutVoirButtonAlbum, voirMoinsButtonAlbum, albumContainer, album2Container);
        toggleContainers(toutVoirButtonArtiste, voirMoinsButtonArtiste, artisteContainer, artiste2Container);
        toggleContainers(toutVoirButtonGenre, voirMoinsButtonGenre, genreContainer, genre2Container);
    });
</script>


</html>
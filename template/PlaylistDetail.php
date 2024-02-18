<?php


use View\Header;
$header = new Header();

use View\Playlist;
$playlistView = new Playlist();

use View\MusiqueView;
$musiqueView = new MusiqueView();

use modele_bd\Connexion;
use modele_bd\PlaylistBD;
use modele_bd\AlbumBD;
use modele_bd\ArtistesBD;
use modele_bd\MusiqueBD;

$connexion = new Connexion();
$connexion->connexionBD();

$playlistManager = new PlaylistBD($connexion->getPDO());
$artisteBD = new ArtistesBD($connexion->getPDO());
$albumBD = new AlbumBD($connexion->getPDO());
$musiqueBD = new MusiqueBD($connexion->getPDO());

$playlist = $playlistManager->getPlaylistById($playlistId);

$musiques = $playlistManager->getSongByIdPlaylist($playlistId);

use View\Footer;
$footer = new Footer();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteButton'])) {

    $resultMessage = $playlistManager->deletePlaylist($playlistId);
    echo '<script>alert("' . $resultMessage . '");</script>';


    
    header('Location: /accueil_user?id='.$userId); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_musique'])) {

    // Récupérer les données du formulaire
    $idMusiqueASupprimer = $_POST['id_musique_a_supprimer'];

    // Supprimer la musique en fonction de l'ID sélectionné
    $resultMessage = $musiqueBD->deleteMusiquePlaylist($idMusiqueASupprimer, $playlistId);

    // Afficher une alerte en fonction du résultat
    header('Location: /detail-playlist?id='.$playlistId.'&userId='.$userId);
    exit();
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel='stylesheet' href='../style/Accueil.css'>
    <link rel='stylesheet' href='../style/detail.css'>
    <link rel='stylesheet' href='../style/bouton_supprimer.css'>
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

    echo $playlistView->renderPlaylist($userId);
    ?>
        <div id='main'>
            <div class='top'>
                <a href="/accueil_user?id=<?php echo $userId?>" ><</a>

                <?php 
                if ($playlist->getNomPlaylist() !== "Favoris") {
                
                ?>
                <form id="deleteForm" method="post" action="">
                    <button type="submit" name="deleteButton">Supprimer</button>
                </form>
                <?php
                }
                ?>
            </div>

            <div class="detail">
                <div class="img-album">
                    <img src="../images/<?php echo $playlist->getImgPlaylist() ?>" alt="<?php echo $playlist->getNomPlaylist() ?>">
                </div>
                <p><?php echo $playlist->getNomPlaylist()?></p>
            </div>

            <div class="top">
                <h2>Musiques</h2>
            </div>
            <div class="musique">
                <?php
                    if (!empty($musiques)) {
                        echo $musiqueView->renderAllMusiquesBis($musiques, $albumBD, $userId, $artisteBD);
                    }else{
                        echo '<p class="p"> Aucune musique </p>';
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
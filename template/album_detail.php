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

use modele_bd\ArtistesBD;
use modele_bd\NoterBD;
use modele\Noter;

$noteManager = new NoterBD($connexion->getPDO());
$artisteManager = new ArtistesBD($connexion->getPDO());

use View\Footer;
$footer = new Footer();

use modele_bd\PlaylistBD;

$playlistBD = new PlaylistBD($connexion->getPDO());

$playlists = $playlistBD->getAllPlaylists($userId);

use modele_bd\RenfermerBD;

$renfermerBD = new RenfermerBD($connexion->getPDO());


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addToPlaylistButton'])) {
    // Assuming you have a Playlist class with getId() method
    $selectedPlaylistId = $_POST['playlist'];
    $idM = $_POST['musicId'];

    $result = $renfermerBD->insertRenfermer($selectedPlaylistId, $idM);
    if($result === 'Duplicate entry'){
        echo '<script>alert("Musique déjà présente dans la playlist")</script>';
    }else{
        header("Location: /detail-playlist?id=".$selectedPlaylistId."&userId=".$userId); // Redirect to a success page
        exit();
    }

    
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel='stylesheet' href='../style/Accueil.css'>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://unpkg.com/htmx.org@latest/dist/htmx.js"></script>
    <script src="../style/note.js" defer></script>
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
            echo "<h1>".$albumManager->getAlbumById($musiqueId)->getTitreAlbum()." par ".$artisteManager->getArtistByAlbumId($musiqueId)->getNomArtistes()."</h1>";
            ?> 
            <div>
                <?php
                echo "<p>Moyenne des notes de l'album : ".$noteManager->calculerMoyenneNotesParAlbum($musiqueId)."/5</p>";
                echo "<p>Votre note : ".$noteManager->getNoteAlbumById(1, $musiqueId)."</p>";
                ?>
                <i class="star">&#9733</i>
                <i class="star">&#9733</i>
                <i class="star">&#9733</i>
                <i class="star">&#9733</i>
                <i class="star">&#9733</i>
                <form id="myForm" method="POST">
                    <input type="hidden" id="hiddenInput" name="hiddenInput">
                    <label for="hiddenInput">Votre note:</label>
                    <input id="valider" type="submit" value="Validez" name="btn-valider">
                </form>
                <?php
                // Vérifier si le formulaire a été soumis
                if(isset($_POST['btn-valider'])) {
                    // Afficher le texte en PHP lorsque le bouton "submit" est cliqué
                    $note = $_POST['hiddenInput'];
                    $notation = new Noter(1, $musiqueId, $note);
                    $noteManager->insertNote($notation);
                }
                ?>
            </div>
            <?php
            foreach($musiques as $key => $musique){
                echo "<li>";
                echo "<div id='son'>";
                echo "<img src='/images/".$albumManager->getAlbumById($musiqueId)->getImgAlbum()."' alt=''>";
                echo "<div>";
                echo "<p>".$musique->getNomMusique()."</p>";
                echo "</div>";
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='musicId' value='".$musique->getIdMusique()."'>";
                echo "<label for='playlist'>Select a playlist:</label>";

                echo "<select name='playlist' >";
                $playlists = $playlistBD->getAllPlaylists($userId);
                foreach ($playlists as $playlist) {
                    echo "<option value='".$playlist->getIdPlaylist()."'>".$playlist->getNomPlaylist()."</option>";
                }
                echo "</select>";
                echo "<input type='submit' name='addToPlaylistButton' value='ajouter'>";
                echo "</form>";
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
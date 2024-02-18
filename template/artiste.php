<?php
use View\Header;
use View\AlbumView;
use View\MusiqueView;
use modele_bd\Connexion;
use modele_bd\ArtistesBD;
use modele_bd\AlbumBD;
use View\Footer;

$footer = new Footer();

$header = new Header();

$connexion = new Connexion();
$connexion->connexionBD();

$artisteBD = new ArtistesBD($connexion->getPDO());

$artiste = $artisteBD->getArtistById($artisteId);
$albumBD = new AlbumBD($connexion->getPDO());
$albums = $albumBD->getAlbumsByArtistId($artisteId);



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteGenreButton'])) {
    // Récupérer les données du formulaire si nécessaire
    foreach ($albums as $album) {
        $albumBD->deleteAlbum($album->getIdAlbum(),$album->getImgAlbum());
    }

    
    $resultMessage = $artisteBD->deleteArtist($artiste->getIdArtistes(), $artiste->getImgArtistes());
    echo '<script>alert("' . $resultMessage . '");</script>';


    
    header('Location: /accueil_admin'); 
    exit();
}


use modele_bd\MusiqueBD;

$musiqueBD = new MusiqueBD($connexion->getPDO());

$allMusiqueArtiste = $musiqueBD->getMusiquesByArtistId($artiste->getIdArtistes());


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_musique'])) {

    // Récupérer les données du formulaire
    $idMusiqueASupprimer = $_POST['id_musique_a_supprimer'];

    // Supprimer la musique en fonction de l'ID sélectionné
    $resultMessage = $musiqueBD->deleteMusique($idMusiqueASupprimer);

    // Afficher une alerte en fonction du résultat
    header('Location: /artiste_detail?id='.$artiste->getIdArtistes());
    exit();
}

use modele_bd\RenfermerBD;
$renfermerBD = new RenfermerBD($connexion->getPDO());
use modele_bd\PlaylistBD;
$playlistBD = new PlaylistBD($connexion->getPDO());

    
    
    
    
    
    
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel='stylesheet' href='../style/Accueil_bd.css'>
    <link rel='stylesheet' href='../style/add_images.css'>
    <link rel='stylesheet' href='../style/detail.css'>
    <link rel='stylesheet' href='../style/bouton_supprimer.css'>
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
            <div class='top'>
                <a href="/accueil_user?id=<?php echo $userId?>" ><</a>

            </div>

            <?php
         
            echo '<div class="detail">';
            echo '<div class="img-artiste">';
            echo '<img src="../images/'.$artiste->getImgArtistes().'" alt="'.$artiste->getNomArtistes().'">';
            echo '</div>';
            echo '<div class="artiste-info">';
            echo '<h2>'.$artiste->getNomArtistes().'</h2>';
            echo '</div>';
            echo '</div>';
            ?>

            
            <div class="top">
                <h2>Albums</h2>
                <a href="/add-album?id=<?php echo $artisteId; ?>">Ajouter un album</a>

            </div>
            <div class="album">
                <?php
                

                AlbumView::renderAlbumsBis($albums, $artisteBD,count($albums),$userId);
                ?>
            </div>

            <div class="top">
                <h2>Musiques</h2>
                <a href="/add-musique?id=<?php echo $artisteId; ?>">Ajouter une musique</a>

            </div>
            <div class="musique">
            <?php
                MusiqueView::renderMusiques($allMusiqueArtiste,$albumBD, $userId,$artisteBD,$renfermerBD,$playlistBD);
            ?>
            

            </div>




        </div>
    </main>

    <?php
    
    echo $footer->render();
    ?>
</body>
<script src="../style/musicLector.js"></script>
<script src="../style/image.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const detailSection = document.querySelector('.detail');
        const modifDetailSection = document.querySelector('.modif-detail');
        const modifierButton = document.querySelector('.top p');
        const annulerModificationButton = document.querySelector('.top p[style="display: none"]');

        // Afficher le formulaire de modification
        modifierButton.addEventListener('click', function () {
            detailSection.style.display = 'none';
            modifDetailSection.style.display = 'flex';
            modifierButton.style.display = 'none';
            annulerModificationButton.style.display = 'block';
        });

        // Annuler la modification et afficher les détails
        annulerModificationButton.addEventListener('click', function () {
            detailSection.style.display = 'flex';
            modifDetailSection.style.display = 'none';
            modifierButton.style.display = 'block';
            annulerModificationButton.style.display = 'none';
        });
    });
</script>

</html>
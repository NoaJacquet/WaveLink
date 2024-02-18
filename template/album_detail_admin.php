<?php

use modele\Album;
use View\Header;
use modele_bd\Connexion;
use modele_bd\AlbumBD;
use modele_bd\ArtistesBD;
use modele_bd\AppartenirBD;
use modele_bd\GenreBD;  
use modele_bd\ContenirBD;
use modele_bd\MusiqueBD;
use View\MusiqueView;
use View\Footer;

$footer = new Footer();
                
                

    
$header = new Header();

$connexion = new Connexion();
$connexion->connexionBD();


$albumBD = new AlbumBD($connexion->getPDO());
$artisteBD = new ArtistesBD($connexion->getPDO());

$albums = $albumBD->getAlbumById($albumId);
$artiste = $artisteBD->getArtistByAlbumId($albums->getIdAlbum());

$artistes = $artisteBD->getAllArtists();

$appartenirBD = new AppartenirBD($connexion->getPDO());
$genreBD = new GenreBD($connexion->getPDO());

$genre = $appartenirBD->getGenresByAlbumId($albums->getIdAlbum());
$allGenres = $genreBD->getAllGenres();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteGenreButton'])) {

    $resultMessage = $albumBD->deleteAlbum($albums->getIdAlbum(), $albums->getImgAlbum());
    echo '<script>alert("' . $resultMessage . '");</script>';


    
    header('Location: /accueil_admin'); 
    exit();
}

$contenirBD = new ContenirBD($connexion->getPDO());

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    // Récupérer les données du formulaire
    $selectedMusiqueId = $_POST['musique_selectionnee'];

    // Supprimer l'album en fonction de la musique sélectionnée
    $resultMessage = $contenirBD->insertContenir($albums->getIdAlbum(),$selectedMusiqueId);
    if ($resultMessage === "musique_existante") {
        echo '<script>alert("La musique existe déjà dans l\'Album.");</script>';
    } else {
        echo '<script>alert("' . $resultMessage . '");</script>';
        // Rediriger vers la page d'accueil admin
        header('Location: /album_detail_admin?id='.$albums->getIdAlbum());
        exit();
    }
}


$musiqueBD = new MusiqueBD($connexion->getPDO());
        
$allMusiqueArtiste = $musiqueBD->getMusiquesByArtistId($artiste->getIdArtistes());



$musiques=$musiqueBD->getMusiquesByAlbumId($albumId);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_musique'])) {

    // Récupérer les données du formulaire
    $idMusiqueASupprimer = $_POST['id_musique_a_supprimer'];

    // Supprimer la musique en fonction de l'ID sélectionné
    $resultMessage = $contenirBD->deleteContenir($albums->getIdAlbum(), $idMusiqueASupprimer);

    // Afficher une alerte en fonction du résultat
    header('Location: /album_detail_admin?id='.$albums->getIdAlbum());
    exit();
}

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
    echo $header->renderBis();
    ?>
    <main>      

        <div id='main'>
            <div class='top'>
                <a href="/accueil_admin" ><</a>
                <p> Modifier </p>
                <p style='display: none'>Annuler la modification</p>
                <form id="deleteForm" method="post" action="">
                    <button type="submit" name="deleteGenreButton">Supprimer</button>
                </form>
            </div>

            <?php
            echo '<div class="detail">';
            echo '<div class="img-album">';
            echo '<img src="../images/'.$albums->getImgAlbum().'" alt="'.$albums->getTitreAlbum().'">';
            echo '</div>';
            echo '<div class="album-info">';
            echo '<h2>'.$albums->getTitreAlbum().'</h2>';
            echo '<p>Année de sortie: '.$albums->getAnneeSortie().'</p>';
            if (!empty($genre)) {
                echo '<p>Genres: ';
                foreach ($genre as $g) {
                    echo $g['nom_Genre'].' ';
                }
                echo '</p>';
            }
            echo '<p>Artiste: <a href="artiste_detail?id='.$artiste->getIdArtistes().'">'.$artiste->getNomArtistes().'</a></p>';
            echo '</div>';
            echo '</div>';
            ?>

            <div class="modif-detail" style ='display:none'>
                <form action="" >

                    <div class="form-label-admin">
                        <label class="custum-file-upload" id="dropZone" for="file" required>
                            <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
                            </div>
                            <div class="text" >
                            <span>Click to upload image</span>
                            </div>
                            <input type="file" name="image" id="inputFile" accept="image/*" required>

                        </label>

                        <div class="image-preview" id="imagePreview" style="display: none;">
                            <span class="image-preview__prompt">Aucune image sélectionnée</span>
                            <img src="" alt="Image preview" class="image-preview__image">
                            <div class="change-image-text" id="changeImageText">Changer l'image</div>
                        </div>



                        <input type="submit" value="Modifier">
                    </div>

                    <div class="detail-album">
                        <label for="titreAlbum">Titre de l'album:</label>
                        <input type="text" id="titreAlbum" name="titreAlbum" value="<?php echo $albums->getTitreAlbum(); ?>" required>

                        <label for="anneeSortie">Année de sortie:</label>
                        <input type="number" id="anneeSortie" name="anneeSortie" value="<?php echo $albums->getAnneeSortie(); ?>" required>

                        <label for="artiste">Artiste:</label>
                        <select id="artiste" name="artiste" required>
                            <?php foreach ($artistes as $art) : ?>
                                <option value="<?php echo $art->getIdArtistes(); ?>" <?php echo ($art->getIdArtistes() == $artiste->getIdArtistes()) ? 'selected' : ''; ?>>
                                    <?php echo $art->getNomArtistes(); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <label for="genres">Genres:</label>
                        <div class="genres-checkboxes">
                            <?php foreach ($allGenres as $genre) : ?>
                                <label class="genre-checkbox">
                                    <?php echo $genre->getNomGenre(); ?>
                                    <input type="checkbox" name="genres[]" value="<?php echo $genre->getIdGenre(); ?>">
                                </label>
                                
                            <?php endforeach; ?>
                        </div>

                    </div>
                </form>

            </div>
            <div class="top">
                <h2>Musique</h2>

                    <form id="" method="post" action="">
                        <select name="musique_selectionnee">
                            <?php foreach ($allMusiqueArtiste as $musique) : ?>
                                <option value="<?= $musique->getIdMusique(); ?>"><?= $musique->getNomMusique(); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" name="ajouter">Ajouter musique</button>
                    </form>
            </div>
            <div class="musique">
                <?php
                MusiqueView::renderAllMusiques($musiques, $albumBD);
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
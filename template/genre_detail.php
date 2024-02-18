<?php
use View\Header;
$header = new Header();

use View\Footer;
$footer = new Footer();

use modele_bd\Connexion;
use modele_bd\GenreBD;

$connexion = new Connexion();
$connexion->connexionBD();

$genreBD = new GenreBD($connexion->getPDO());

$genre = $genreBD->getGenreById($genreId); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteGenreButton'])) {
    // Récupérer les données du formulaire si nécessaire

    $resultMessage = $genreBD->deleteGenre($genre->getIdGenre(), $genre->getImgGenre());
    echo '<script>alert("' . $resultMessage . '");</script>';


    
    header('Location: /accueil_admin'); 
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel='stylesheet' href='../style/Accueil_bd.css'>
    <link rel='stylesheet' href='../style/add_images.css'>
    <link rel='stylesheet' href='../style/detail.css'>
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
            echo '<div class="img-genre">';
            echo '<img src="../images/'.$genre->getImgGenre().'" alt="'.$genre->getNomGenre().'">';
            echo '</div>';
            echo '<div class="genre-info">';
            echo '<h2>'.$genre->getNomGenre().'</h2>';
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

                    <div class="detail-genre">
                        <label for="nomGenre">Nom de l'genre:</label>
                        <input type="text" id="nomGenre" name="nomGenre" value="<?php echo $genre->getNomGenre(); ?>" required>

                    </div>
                </form>
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
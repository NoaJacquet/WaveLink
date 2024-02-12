<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel='stylesheet' href='../style/Accueil_bd.css'>
    <link rel='stylesheet' href='../style/add_images.css'>

    <meta charset="UTF-8">
    <title>Accueil</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
</head>
<body>
    <?php
    use View\Header;
    $header = new Header();
    echo $header->render();
    ?>
    <main>
        

        <div id='main'>
            <div class='top'>
                <a href="/accueil_admin" ><</a>
                <p> Modifier </p>
            </div>

            <?php
            use modele_bd\Connexion;
            use modele_bd\AlbumBD;
            use modele_bd\ArtistesBD;

            $connexion = new Connexion();
            $connexion->connexionBD();

            $albumBD = new AlbumBD($connexion->getPDO());
            $artisteBD = new ArtistesBD($connexion->getPDO());

            $albums = $albumBD->getAlbumById($albumId);

            echo '<div class="detail">';
            echo '<div class="imge-album>"';
            echo '<img src="'.$albums->getImgAlbum().'" alt="'.$albums->getTitreAlbum().'"';
            echo '</div>';
            echo '</div>';
            ?>
            <div class="modif-detail">
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

                            </div>
                        </label>

                        <div class="image-preview" id="imagePreview" style="display: none;">
                            <span class="image-preview__prompt">Aucune image sélectionnée</span>
                            <img src="" alt="Image preview" class="image-preview__image">
                            <div class="change-image-text" id="changeImageText">Changer l'image</div>
                        </div>
                    </div>


                </form>

            </div>



        </div>
    
 
    </main>
    <footer>
            <div><p id='music-name'>a</p></div>
            <div id='lector-div'>
                <input type="range" id="lector" min ="0" value="0" step="1" width="10">
                <span id="progress-time">0:00</span> / <span id="total-time">1:00</span>
                <input type="range" id="sound-bar" min="0" max="100" step="1">
                <span id="sound-volume">50%</span>
            </div>
            <div id='play-div'>
                <audio src="../musique/plk-mignon-tout-plein.mp3"></audio>
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" id="play-button" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 0 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" id="pause-button" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M5 6.25a1.25 1.25 0 1 1 2.5 0v3.5a1.25 1.25 0 1 1-2.5 0zm3.5 0a1.25 1.25 0 1 1 2.5 0v3.5a1.25 1.25 0 1 1-2.5 0z"/>
                </svg>
            </div>
    </footer>
</body>
<script src="../style/musicLector.js"></script>

<script>
        document.addEventListener("DOMContentLoaded", () => {
            const dropZone = document.getElementById("dropZone");
            const inputFile = document.getElementById("inputFile");
            const imagePreview = document.getElementById("imagePreview");
    
            dropZone.addEventListener("click", () => {
                inputFile.click();
            });
    
            inputFile.addEventListener("change", handleFileSelect);
    
            // Ajoutez cet événement de clic pour changer l'image
            imagePreview.querySelector(".image-preview__image").addEventListener("click", () => {
                inputFile.click();
            });
    
            function handleFileSelect() {
                const files = inputFile.files;
    
                if (files.length > 0) {
                    const reader = new FileReader();
    
                    reader.onload = function (e) {
                        imagePreview.querySelector(".image-preview__image").src = e.target.result;
                        imagePreview.querySelector(".image-preview__prompt").style.display = "none";
                        dropZone.style.display = "none";
                        imagePreview.style.display = "block";
                        document.querySelector(".change-image-section").style.display = "block";
                    };
    
                    reader.readAsDataURL(files[0]);
                }
            }
        });

    </script>

<style>
    .change-image-text {
        position: absolute;
        top: 50%; /* Ajustez la position verticale selon vos besoins */
        left: 50%; /* Ajustez la position horizontale selon vos besoins */
        transform: translate(-50%, -50%);
        display: none;
        color: white; /* Ajoutez d'autres styles selon vos besoins */
        background-color: rgba(0, 0, 0, 0.7); /* Ajoutez d'autres styles selon vos besoins */
        padding: 10px; /* Ajoutez d'autres styles selon vos besoins */
        border-radius: 5px; /* Ajoutez d'autres styles selon vos besoins */
        cursor: pointer;
    }

    .image-preview:hover .change-image-text {
        display: block;
    }
</style>

<script>
    // Récupérer les éléments nécessaires
    const imagePreview = document.getElementById('imagePreview');
    const changeImageText = document.getElementById('changeImageText');

    // Ajouter un gestionnaire d'événement au survol de l'image
    imagePreview.addEventListener('mouseover', function () {
        changeImageText.style.display = 'block';
    });

    // Ajouter un gestionnaire d'événement lorsque la souris quitte l'image
    imagePreview.addEventListener('mouseout', function () {
        changeImageText.style.display = 'none';
    });
</script>

</html>
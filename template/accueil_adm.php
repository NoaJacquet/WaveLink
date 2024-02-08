<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel='stylesheet' href='../style/Accueil_bd.css'>
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
    <div id='playlist'>
        <ul>
            <li><a href="">Album</a></li>
            <li><a href="">Artistes</a></li>
            <li><a href="">Utilisateur</a></li>
        </ul>
    </div>

    <div id='main'>
        <div class="top-album">
                <h2>Album</h2>
                <p id='tout-voir'>Tout voir</p>
                <p id='voir-moins' style="display:none">Voir moins</p>
        </div>  
        <div class="album" >
              
            <?php
            use modele_bd\Connexion;
            use modele_bd\AlbumBD;
            use modele_bd\ArtistesBD;
    
            $connexion = new Connexion();
            $connexion->connexionBD();
    
            $albumBD = new AlbumBD($connexion->getPDO());
            $artisteBD = new ArtistesBD($connexion->getPDO());

            $albums = $albumBD->getAllAlbums();

            $count = 0;

            foreach ($albums as $album) {
                $artiste = $artisteBD->getArtistByAlbumId($album->getIdAlbum());
                echo '<div class="card-album">';
                echo '<a  id="'.$album->getIdAlbum().'" href="/accueil">';
                echo '<img src="images/' . rawurlencode($album->getImgAlbum()) . '" alt="' . $album->getTitreAlbum(). '">';
                echo '<p class="titre">' . $album->getTitreAlbum().'</p>';
                echo '<p class="">' . $artiste->getNomArtistes().'</p>';
                echo '</a>';
                echo '</div>';

                $count++;

            // Arrêter après avoir affiché les 5 premiers albums
                if ($count >= 6) {
                    break;
                }

            }

            ?>

        </div>
        <div class="album2" style="display: none;">
              
            <?php
            $connexion = new Connexion();
            $connexion->connexionBD();
    
            $albumBD = new AlbumBD($connexion->getPDO());
            $artisteBD = new ArtistesBD($connexion->getPDO());

            $albums = $albumBD->getAllAlbums();


            foreach ($albums as $album) {
                $artiste = $artisteBD->getArtistByAlbumId($album->getIdAlbum());
                echo '<div class="card-album">';
                echo '<a  id="'.$album->getIdAlbum().'" href="/accueil">';
                echo '<img src="images/' . rawurlencode($album->getImgAlbum()) . '" alt="' . $album->getTitreAlbum(). '">';
                echo '<p class="titre">' . $album->getTitreAlbum().'</p>';
                echo '<p class="">' . $artiste->getNomArtistes().'</p>';
                echo '</a>';
                echo '</div>';



            }

            ?>

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
    document.addEventListener("DOMContentLoaded", function () {
        // Sélectionner les éléments DOM
        var toutVoirButton = document.getElementById('tout-voir');
        var voirMoinsButton = document.getElementById('voir-moins');
        var albumContainer = document.querySelector('.album');
        var album2Container = document.querySelector('.album2');

        // Ajouter un gestionnaire d'événements au bouton "Tout voir"
        toutVoirButton.addEventListener('click', function () {
            // Cacher le premier conteneur d'albums et le bouton "Tout voir"
            albumContainer.style.display = 'none';
            toutVoirButton.style.display = 'none';

            // Afficher le deuxième conteneur d'albums et le bouton "Voir moins"
            album2Container.style.display = 'block';
            voirMoinsButton.style.display = 'block'; // Utiliser 'inline' si c'est un élément en ligne
        });

        // Ajouter un gestionnaire d'événements au bouton "Voir moins"
        voirMoinsButton.addEventListener('click', function () {
            // Cacher le deuxième conteneur d'albums et le bouton "Voir moins"
            voirMoinsButton.style.display = 'none';
            album2Container.style.display = 'none';

            // Afficher le premier conteneur d'albums et le bouton "Tout voir"
            albumContainer.style.display = 'block';
            toutVoirButton.style.display = 'block'; // Utiliser 'inline' si c'est un élément en ligne
        });
    });
</script>

</html>
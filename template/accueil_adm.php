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
        <div id='main'>
            <div class="top">
                    <h2>Album</h2>
                    <p id='tout-voir'>Tout voir</p>
                    <p id='voir-moins' style="display:none">Voir moins</p>
            </div>  
            <div class="album" style="display: none;" >
                
                <?php
                use modele_bd\Connexion;
                use modele_bd\AlbumBD;
                use modele_bd\ArtistesBD;
                use View\AlbumView;
        
                $connexion = new Connexion();
                $connexion->connexionBD();
        
                $albumBD = new AlbumBD($connexion->getPDO());
                $artisteBD = new ArtistesBD($connexion->getPDO());

                $albums = $albumBD->getAllAlbums();

                AlbumView::renderAlbums($albums, $artisteBD, $albumBD);

                ?>

            </div>
            <div class="album2" >
                
                <?php
                
                AlbumView::renderAllAlbums($albums, $artisteBD, $albumBD);

                ?>

            </div>
            <div class="top">
                <h2>Artistes</h2>
                <p id='tout-voir-artiste'>Tout voir</p>
                <p id='voir-moins-artiste' style="display:none">Voir moins</p>
            </div>  

            <div class="artiste">
                <?php
                use View\ArtisteView;

                $artistes = $artisteBD->getAllArtists();
                

                ArtisteView::renderArtistes($artistes);
                ?>
            </div>
            <div class="artiste2" style="display: none;">
                <?php
                ArtisteView::renderAllArtistes($artistes);
                ?>
            </div>

            <div class="top">
                <h2>Genres</h2>
                <p id='tout-voir-genre'>Tout voir</p>
                <p id='voir-moins-genre' style="display:none">Voir moins</p>
            </div>  
            <div class="genre">
                <?php
                use modele_bd\GenreBD;
                use View\GenreView;

                $genreBD = new GenreBD($connexion->getPDO());
                $genres = $genreBD->getAllGenres();

                GenreView::renderGenres($genres, $genreBD);
                ?>
            </div>
            <div class="genre2" style="display: none;">
                <?php
                GenreView::renderAllGenres($genres, $genreBD);
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
                voirMoinsButton.style.display = 'block';
                container1.style.display = 'none';
                toutVoirButton.style.display = 'none';
            });

            voirMoinsButton.addEventListener('click', function () {
                voirMoinsButton.style.display = 'none';
                container2.style.display = 'none';
                container1.style.display = 'flex';
                toutVoirButton.style.display = 'block';
            });
        }

        // Appliquer la logique pour chaque section
        toggleContainers(toutVoirButtonAlbum, voirMoinsButtonAlbum, albumContainer, album2Container);
        toggleContainers(toutVoirButtonArtiste, voirMoinsButtonArtiste, artisteContainer, artiste2Container);
        toggleContainers(toutVoirButtonGenre, voirMoinsButtonGenre, genreContainer, genre2Container);
    });
</script>


</html>
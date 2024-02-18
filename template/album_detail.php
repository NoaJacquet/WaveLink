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
    use View\Header;
    $header = new Header();
    echo $header->render();
    ?>
    <main>
    <?php
    use View\Playlist;
    $playlist = new Playlist();
    echo $playlist->render();
    ?>
    <div class="slider-container">
    <div id='main'>
            <?php
            use modele_bd\Connexion;
            use modele_bd\MusiqueBD;
            use modele_bd\AlbumBD;
            use modele_bd\ArtistesBD;
            use modele_bd\NoterBD;
            use modele\Noter;
            
            $connexion = new Connexion();
            $connexion->connexionBD();

            $noteManager = new NoterBD($connexion->getPDO());
            $musiqueManager = new MusiqueBD($connexion->getPDO());
            $artisteManager = new ArtistesBD($connexion->getPDO());
            $albumManager = new AlbumBD($connexion->getPDO());
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
            $musiques = $musiqueManager->getMusiquesByAlbumId($musiqueId);
            foreach($musiques as $key => $musique){
                echo "<li>";
                echo "<div id='son'>";
                echo "<img src='/images/".$albumManager->getAlbumById($musiqueId)->getImgAlbum()."' alt=''>";
                echo "<div>";
                echo "<p>".$musique->getNomMusique()."</p>";
                echo "</div>";
                echo "</div>";
                echo "</li>";
            }
            ?> 
    </div>
    </div>
       </main>
    <?php
    use View\Footer;
    $footer = new Footer();
    echo $footer->render();
    ?>
</div>
</body>
<script src="../style/musicLector.js"></script>

</html>
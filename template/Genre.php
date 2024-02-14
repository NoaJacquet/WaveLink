<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel='stylesheet' href='../style/Accueil.css'>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://unpkg.com/htmx.org@latest/dist/htmx.js"></script>

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
    <div id='main'>

    <h2>Album de genre :</h2>
    <?php       
                use modele_bd\Connexion;
                use modele_bd\GenreBD;
        
                $connexion = new Connexion();
                $connexion->connexionBD();
        
                $genreManager = new GenreBD($connexion->getPDO());

                $albums = $genreManager->getAlbumByIdGenre(1);
                foreach($albums as $key => $album){
                    echo "<li>";
                    echo "<div id='barre'></div>";
                    echo "<a href=''>";
                    echo "<div id='detail-playlist'>";
                    echo "<img src='rap.jpg' alt=''>";
                    echo "<p>".$album->get()."</p>";
                    echo "</div>";
                    echo "</a>";
                    echo "</li>";
                }
    ?>
    </div>
    </main>
    <?php
        use View\Footer;
        $footer = new Footer();
        echo $footer->render();
        ?>
</body>
<script src="../style/musicLector.js"></script>
</html>
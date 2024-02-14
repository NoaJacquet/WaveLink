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
        <ul>
            
            <?php   
                use modele_bd\Connexion;
                use modele_bd\GenreBD;   
                $connexion = new Connexion();
                $connexion->connexionBD();  
                $genreManager = new GenreBD($connexion->getPDO());
                $genres = $genreManager->getAllGenres();
                foreach($genres as $key => $genre){
                    echo "<li>";
                    echo "<a href='/genre'>";
                    echo "<div id='genre'>";
                    echo "<p>".$genre->getNomGenre()."</p>";
                    echo "</div>";
                    echo "</a>";
                    echo "</li>";
                }
            ?>
        </ul>
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
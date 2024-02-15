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
            <?php
            use modele_bd\Connexion;
            use modele_bd\PlaylistBD;
    
            $connexion = new Connexion();
            $connexion->connexionBD();
    
            $playlistManager = new PlaylistBD($connexion->getPDO());

            echo '<h1>'.$playlistManager->getPlaylistById(1)->getNomPlaylist().'</h1>';
            $musiques = $playlistManager->getSongByIdPlaylist(1);
            foreach($musiques as $key => $musique){
                echo "<li>";
                echo "<div id='son'>";
                echo "<img src='rap.jpg' alt=''>";
                echo "<div>";
                echo "<p>".$musique->getNomMusique()."</p>";
                //echo "<p>".$musique->getInterpreteMusique()."</p>";
                echo "</div>";
                echo "</div>";
                echo "</li>";
            }
            ?> 
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
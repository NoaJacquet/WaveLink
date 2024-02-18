<?php

use View\Header;
$header = new Header();

use View\Playlist;
$playlist = new Playlist();

use modele_bd\Connexion;
use modele_bd\PlaylistBD;

$connexion = new Connexion();
$connexion->connexionBD();

$playlistManager = new PlaylistBD($connexion->getPDO());

$musiques = $playlistManager->getSongByIdPlaylist($playlistId);

use View\Footer;
$footer = new Footer();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteButton'])) {

    $resultMessage = $playlistManager->deletePlaylist($playlistId);
    echo '<script>alert("' . $resultMessage . '");</script>';


    
    header('Location: /accueil_user?id='.$userId); 
    exit();
}


?>


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

    echo $header->render();
    ?>
    <main>
    <?php

    echo $playlist->renderPlaylist($userId);
    ?>
    <div id='main'>
            <div class='top'>
                <a href="/accueil_user?id=<?php echo $userId?>" ><</a>
                <form id="deleteForm" method="post" action="">
                    <button type="submit" name="deleteButton">Supprimer</button>
                </form>
            </div>

            <div class="detail">
                <div class="img-album">
                    <img src="../images/$albums->getImgAlbum()" alt="">
                </div>'
            </div>

            <?php

            foreach($musiques as $musique){
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

    echo $footer->render();
    ?>
</div>
</body>
<script src="../style/musicLector.js"></script>
</html>
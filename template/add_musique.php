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
    use View\Header;
    $header = new Header();
    echo $header->render();
    ?>
    <main>
    <?php
    use modele_bd\Connexion;
    use modele_bd\MusiqueBD;

    $connexion = new Connexion();
    $connexion->connexionBD();


    $musiqueBD = new MusiqueBD($connexion->getPDO());

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Ajouter'])) {
        $nomMusique = $_POST['nomMusique'];
        $musique_file = $_FILES['musique'];
        
        // Vérifier si un fichier MP3 a été téléchargé
        if ($_FILES['musique']['error'] == UPLOAD_ERR_OK) {
            $musique_file = $_FILES['musique'];
            $musiqueFilename = basename($musique_file['name']);
            $musiqueFilename = $musiqueFilename . '_' . uniqid();
            $musiquePath = "musiques/" . $musiqueFilename;
            move_uploaded_file($musique_file['tmp_name'], $musiquePath);
        } else {
            // Aucun fichier MP3 fourni, utilisez la valeur par défaut 'rien.mp3'
            $musiqueFilename = 'rien.mp3';
            $musiquePath = "musiques/" . $musiqueFilename;
        }

        // Insérer la musique dans la base de données
        $resultMusique = $musiqueBD->insertMusique($nomMusique, $musiqueFilename, $artisteId);

        if ($resultMusique) {
            echo '<script>alert("La musique a été ajoutée avec succès.");</script>';
        } else {
            echo '<script>alert("Erreur lors de l\'ajout de la musique.");</script>';
            // Gérer l'erreur, vous pouvez rediriger vers une autre page ou afficher un message d'erreur spécifique
        }

        // Rediriger vers la page de détail de l'artiste
        header('Location: /artiste_detail?id='.$artisteId);
        exit();
    }
    ?>

    <div id='main'>
        <div class="modif-detail">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-label-admin">
                        <label for="musique">Fichier MP3:</label>
                        <input type="file" name="musique" id="inputMusique" accept="audio/mp3">

                        <input type="submit" value="Ajouter" name="Ajouter">
                </div>
                
                <div class="detail-musique">
                    <label for="nomMusique">Nom de la musique:</label>
                    <input type="text" id="nomMusique" name="nomMusique" value="" required>
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
<script src="../style/image.js"></script>


</html>
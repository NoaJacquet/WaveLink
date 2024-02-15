<?php
use View\Header;
use modele_bd\Connexion;
use modele_bd\MusiqueBD;
use View\Footer;

$header = new Header();
$footer = new Footer();

$connexion = new Connexion();
$connexion->connexionBD();


$musiqueBD = new MusiqueBD($connexion->getPDO());
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Ajouter'])) {
    
    $nomMusique = $_POST['nomMusique'];        
    // Vérifier si un fichier MP3 a été téléchargé
    $musique_file = $_FILES['musique'];

    // Vérifier si un fichier MP3 a été téléchargé
    
    if ($musique_file['error'] == UPLOAD_ERR_OK) {
        $musiqueFilename = basename($musique_file['name']);
        $musiqueFilename = uniqid().$musiqueFilename;
        $musiquePath = "musique/" . $musiqueFilename;
        move_uploaded_file($musique_file['tmp_name'], $musiquePath);
    } else {
        $musiqueFilename = 'rien.mp3';
    }
    


    // Insérer la musique dans la base de données
    $resultMusique = $musiqueBD->insertMusique($nomMusique, $musiqueFilename, $artisteId);

    if ($resultMusique) {
        echo '<script>alert("La musique a été ajoutée avec succès.");</script>';
        header('Location: /artiste_detail?id='.$artisteId);
        exit();
    } else {
        echo '<script>alert("Erreur lors de l\'ajout de la musique.");</script>';
        // Gérer l'erreur, vous pouvez rediriger vers une autre page ou afficher un message d'erreur spécifique
    }

    // Rediriger vers la page de détail de l'artiste
    
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

    <?php
    echo $footer->render();
    ?>
</body>
<script src="../style/musicLector.js"></script>
<script src="../style/image.js"></script>


</html>
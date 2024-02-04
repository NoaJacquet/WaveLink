<?php
use Classes\Header;   
use Classes\Playlist; 
use Classes\Footer;
use Classes\ChoixSon;
spl_autoload_register(static function(string $fqcn) {
    // $fqcn contient Model\Thread\Message par exemple
    // remplaçons les \ par des / et ajoutons .php à la fin.
    // on obtient Model/Thread/Message.php
    $path = str_replace('\\', '/', $fqcn).'.php';
    require_once('_inc/'.$path);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel='stylesheet' href='_inc/style/Accueil.css'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $header = new Header();
    echo $header->render();
    ?>
    <main>
    <?php
    $playlist = new Playlist();
    echo $playlist->render();
    $choixSon = new ChoixSon();
    echo $choixSon->render();
    ?>
    </main>
    <?php
    $footer = new Footer();
    echo $footer->render();
    ?>
</body>
<script src="_inc/style/musicLector.js"></script>
</html>
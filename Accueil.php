<!DOCTYPE html>
<html lang="en">
<head>
    <link rel='stylesheet' href='_inc/style/Accueil.css'>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <?php
    use Classes\Header;
    spl_autoload_register(static function(string $fqcn) {
        // $fqcn contient Model\Thread\Message par exemple
        // remplaçons les \ par des / et ajoutons .php à la fin.
        // on obtient Model/Thread/Message.php
        $path = str_replace('\\', '/', $fqcn).'.php';
        require_once('_inc/'.$path);
    });
    $header = new Header();
    echo $header->render();
    ?>
    <main>
    <div id='playlist'>
        <h2>Playlist</h2>
        <ul>
            <?php

            ?>
        </ul>
    </div>
    <div id='main'>
        <p></p>
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
                <audio src="plk-mignon-tout-plein.mp3"></audio>
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
<script src="_inc/style/musicLector.js"></script>
</html>
<?php

require_once 'vendor/autoload.php';

define('SQLITE_DB', 'test.db');
$pdo = new PDO('sqlite:' . SQLITE_DB);

function yaml_parse($yamlFile)
{
    $yamlContents = file_get_contents($yamlFile);

    // Simple YAML parsing logic (you might want to use a more robust parser)
    $data = [];
    $lines = explode("\n", $yamlContents);
    $currentKey = null;
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || $line[0] === '#') {
            continue; // Ignore empty lines and comments
        }

        if (strpos($line, ':') !== false) {
            list($key, $value) = explode(':', $line, 2);
            $currentKey = trim($key);
            $data[$currentKey] = trim($value);
        } elseif ($currentKey !== null) {
            $data[$currentKey] .= "\n" . $line;
        }
    }

    return $data;
}

switch ($argv[1]) {
    case 'create-database':
        echo '→ Go create database "test.db"' . PHP_EOL;
        shell_exec('sqlite3 ' . SQLITE_DB);
        break;

    case 'create-tables':
        echo '→ Go create tables' . PHP_EOL;
        $sqlScript = <<<EOF
        CREATE TABLE Album (
            id_Album          TEXT PRIMARY KEY, AUTOINCREMENT,
            titre_Album       TEXT,
            genre_Album       TEXT,
            annee_Sortie      TEXT,
            img_Album         TEXT,
            compositeur_Album TEXT
          );
          
          CREATE TABLE Appartenir (
            id_Genre TEXT NOT NULL, AUTOINCREMENT,
            id_Album TEXT NOT NULL, AUTOINCREMENT,
            PRIMARY KEY (id_Genre, id_Album),
            FOREIGN KEY (id_Album) REFERENCES Album (id_Album),
            FOREIGN KEY (id_Genre) REFERENCES Genre (id_Genre)
          );
          
          CREATE TABLE Artistes (
            id_Artistes  TEXT PRIMARY KEY,
            nom_Artistes TEXT,
            img_Artistes TEXT
          );
          
          CREATE TABLE Avoir (
            id_Playlist    TEXT NOT NULL, AUTOINCREMENT,
            id_Utilisateur TEXT NOT NULL, AUTOINCREMENT,
            PRIMARY KEY (id_Playlist, id_Utilisateur),
            FOREIGN KEY (id_Utilisateur) REFERENCES Utilisateur (id_Utilisateur),
            FOREIGN KEY (id_Playlist) REFERENCES Playlist (id_Playlist)
          );
          
          CREATE TABLE Composer (
            id_Musique  TEXT NOT NULL, AUTOINCREMENT,
            id_Artistes TEXT NOT NULL, AUTOINCREMENT,
            PRIMARY KEY (id_Musique, id_Artistes),
            FOREIGN KEY (id_Artistes) REFERENCES Artistes (id_Artistes),
            FOREIGN KEY (id_Musique) REFERENCES Musique (id_Musique)
          );
          
          CREATE TABLE Contenir (
            id_Album   TEXT NOT NULL, AUTOINCREMENT,
            id_Musique TEXT NOT NULL, AUTOINCREMENT,
            PRIMARY KEY (id_Album, id_Musique),
            FOREIGN KEY (id_Musique) REFERENCES Musique (id_Musique),
            FOREIGN KEY (id_Album) REFERENCES Album (id_Album)
          );
          
          CREATE TABLE Creer (
            id_Artistes TEXT NOT NULL, AUTOINCREMENT,
            id_Album    TEXT NOT NULL, AUTOINCREMENT,
            PRIMARY KEY (id_Artistes, id_Album),
            FOREIGN KEY (id_Album) REFERENCES Album (id_Album),
            FOREIGN KEY (id_Artistes) REFERENCES Artistes (id_Artistes)
          );
          
          CREATE TABLE Genre (
            id_Genre  TEXT PRIMARY KEY,
            nom_Genre TEXT
          );
          
          CREATE TABLE Interpreter (
            id_Musique  TEXT NOT NULL, AUTOINCREMENT,
            id_Artistes TEXT NOT NULL, AUTOINCREMENT,
            PRIMARY KEY (id_Musique, id_Artistes),
            FOREIGN KEY (id_Artistes) REFERENCES Artistes (id_Artistes),
            FOREIGN KEY (id_Musique) REFERENCES Musique (id_Musique)
          );
          
          CREATE TABLE Musique (
            id_Musique           TEXT PRIMARY KEY, AUTOINCREMENT,
            nom_Musique          TEXT,
            genre_Musique        TEXT,
            interprete_Musique   TEXT,
            Compositeur_Musique  TEXT,
            annee_Sortie_Musique composer require symfony/yaml     TEXT
          );
          
          CREATE TABLE NOTE (
            id_Note          TEXT PRIMARY KEY, AUTOINCREMENT,
            id_Utilisateur_1 TEXT, AUTOINCREMENT,
            id_Album         TEXT, AUTOINCREMENT,
            note             TEXT,
            id_Utilisateur_2 TEXT NOT NULL,
            FOREIGN KEY (id_Utilisateur_2) REFERENCES Utilisateur (id_Utilisateur)
          );composer require symfony/yaml
          
          CREATE TABLE Noter (
            id_Utilisateur TEXT NOT NULL, AUTOINCREMENT,
            id_Album       TEXT NOT NULL, AUTOINCREMENT,
            note           TEXT,
            PRIMARY KEY (id_Utilisateur, id_Album),
            FOREIGN KEY (id_Album) REFERENCES Album (id_Album),
            FOREIGN KEY (id_Utilisateur) REFERENCES Utilisateur (id_Utilisateur)
          );
          
          CREATE TABLE Playlist (
            id_Playlist composer require symfony/yaml
          CREATE TABLE Renfermer (
            id_Playlist TEXT NOT NULL,
            id_Musique  TEXT NOT NULL,
            PRIMARY KEY (id_Playlist, id_Musique),
            FOREIGN KEY (id_Musique) REFERENCES Musique (id_Musique),
            FOREIGN KEY (id_Playlist) REFERENCES Playlist (id_Playlist)
          );
          
          CREATE TABLE Utilisateur (
            id_Utilisateur  TEXT PRIMARY KEY,
            nom_Utilisateur TEXT,
            mdp_Utilisateur TEXT,
            img_Utilisateur TEXT
          );
          
        
        EOF;
        break;

    case 'delete-tables':
        echo '→ Go delete tables' . PHP_EOL;
        $sqlScript = <<<EOF

    DROP TABLE IF EXISTS Utilisateur;
    DROP TABLE IF EXISTS Genre;
    DROP TABLE IF EXISTS Album;
    DROP TABLE IF EXISTS Musique;
    DROP TABLE IF EXISTS Artistes;
    DROP TABLE IF EXISTS Playlist;
    DROP TABLE IF EXISTS Avoir;
    DROP TABLE IF EXISTS Appartenir;
    DROP TABLE IF EXISTS Composer;
    DROP TABLE IF EXISTS Contenir;
    DROP TABLE IF EXISTS Creer;
    DROP TABLE IF EXISTS Interpreter;
    DROP TABLE IF EXISTS Renfermer;
    DROP TABLE IF EXISTS Noter; 
    DROP TABLE IF EXISTS NOTE;

EOF;
        break;

        case 'load-data':
            echo '→ Go load data to tables' . PHP_EOL;
    
            $yamlFile = 'yaml/extrait.yml';
    
            if (file_exists($yamlFile)) {
                $yamlData = file_get_contents($yamlFile);
                $data = yaml_parse($yamlData); // Utilisez yaml_parse pour analyser le fichier YAML
    
                if (isset($data) && is_array($data)) {
                    foreach ($data as $entry) {
                        $stmt = $pdo->prepare("INSERT INTO Album (id_Album, titre_Album, genre_Album, annee_Sortie, img_Album, compositeur_Album) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$entry['entryId'], $entry['title'], $entry['genre'], $entry['releaseYear'], $entry['img'], null]);
    
                        // Ajoutez des déclarations INSERT similaires pour les autres tables au besoin
                    }
    
                    echo 'Data loaded successfully.' . PHP_EOL;
                } else {
                    echo 'Error parsing YAML data.' . PHP_EOL;
                }
            } else {
                echo 'YAML file not found.' . PHP_EOL;
            }
            break;

    default:
        echo 'No action defined 🙀'.PHP_EOL;
        break;
}

if (isset($sqlScript)) {
    try {
        $pdo->exec($sqlScript);
        echo 'Database setup successfully.' . PHP_EOL;
    } catch (PDOException $e) {
        var_dump($e->getMessage());
    }
}
?>

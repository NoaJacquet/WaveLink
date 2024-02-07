<?php


$dbPath = realpath(__DIR__ . '/../Data/db.sqlite');
$pdo = new PDO('sqlite:' . $dbPath);

function recupInformations($cheminFichierYAML) {
  // Ouvrir le fichier en lecture
  $handle = fopen($cheminFichierYAML, 'r');

  // Vérifier si le fichier est ouvert avec succès
  if ($handle){
      $albums = [];
      $album = null; 

      // Lire chaque ligne du fichier
      while (($ligne = fgets($handle)) !== false) {
          // Ignorer les lignes vides
          if (trim($ligne) === '') {
              continue;
          }

          // Détecter le début et la fin d'un album
          if ($ligne[0] === '-') {
              // Début d'un nouvel album
              if ($album !== null) {
                  // Ajouter l'album précédent à la liste
                  $albums[] = $album;
              }
              $album = [];
              // Supprimer le '-' et l'espace au début de la ligne
              $ligne = ltrim($ligne, '- ');
              list($cle, $valeur) = explode(':', $ligne, 2) + [null, null];
          
              $album[$cle] = $valeur;
          }
          elseif ($album !== null && $ligne[0] === ' ') {
              // À l'intérieur d'un album, traiter les paires clé-valeur
              list($cle, $valeur) = explode(':', $ligne, 2) + [null, null];
              
              $cle = trim($cle);
              $valeur = trim($valeur);

              $album[$cle] = $valeur;
          }

      }
      if ($album !== null) {
          $albums[] = $album;
      }
      fclose($handle);
      return $albums;
  } else {
      echo 'Erreur lors de l\'ouverture du fichier.';
      return [];
  }
}


switch ($argv[1]) {
    case 'create-database':
        echo '→ Go create database "db.sqlite"' . PHP_EOL;
        break;

    case 'create-tables':
        echo '→ Go create tables' . PHP_EOL;
        $sqlScript = <<<EOF
        CREATE TABLE Album (
          id_Album          INTEGER PRIMARY KEY AUTOINCREMENT,
          titre_Album       TEXT,
          genre_Album       TEXT,
          annee_Sortie      TEXT,
          img_Album         TEXT
        );
      
        CREATE TABLE Appartenir (
            id_Genre INTEGER NOT NULL,
            id_Album INTEGER NOT NULL,
            PRIMARY KEY (id_Genre, id_Album),
            FOREIGN KEY (id_Album) REFERENCES Album (id_Album),
            FOREIGN KEY (id_Genre) REFERENCES Genre (id_Genre)
        );
        
        CREATE TABLE Artistes (
            id_Artistes  INTEGER PRIMARY KEY AUTOINCREMENT,
            nom_Artistes TEXT,
            img_Artistes TEXT
        );
        
        CREATE TABLE Avoir (
            id_Playlist    INTEGER NOT NULL,
            id_Utilisateur INTEGER NOT NULL,
            PRIMARY KEY (id_Playlist, id_Utilisateur),
            FOREIGN KEY (id_Utilisateur) REFERENCES Utilisateur (id_Utilisateur),
            FOREIGN KEY (id_Playlist) REFERENCES Playlist (id_Playlist)
        );
        
        CREATE TABLE Composer (
            id_Musique  INTEGER NOT NULL,
            id_Artistes INTEGER NOT NULL,
            PRIMARY KEY (id_Musique, id_Artistes),
            FOREIGN KEY (id_Artistes) REFERENCES Artistes (id_Artistes),
            FOREIGN KEY (id_Musique) REFERENCES Musique (id_Musique)
        );
        
        CREATE TABLE Contenir (
            id_Album   INTEGER NOT NULL,
            id_Musique INTEGER NOT NULL,
            PRIMARY KEY (id_Album, id_Musique),
            FOREIGN KEY (id_Musique) REFERENCES Musique (id_Musique),
            FOREIGN KEY (id_Album) REFERENCES Album (id_Album)
        );
        
        CREATE TABLE Creer (
            id_Artistes INTEGER NOT NULL,
            id_Album    INTEGER NOT NULL,
            PRIMARY KEY (id_Artistes, id_Album),
            FOREIGN KEY (id_Album) REFERENCES Album (id_Album),
            FOREIGN KEY (id_Artistes) REFERENCES Artistes (id_Artistes)
        );
        
        CREATE TABLE Genre (
            id_Genre  INTEGER PRIMARY KEY AUTOINCREMENT,
            nom_Genre TEXT
        );
        
        CREATE TABLE Interpreter (
            id_Musique  INTEGER NOT NULL,
            id_Artistes INTEGER NOT NULL,
            PRIMARY KEY (id_Musique, id_Artistes),
            FOREIGN KEY (id_Artistes) REFERENCES Artistes (id_Artistes),
            FOREIGN KEY (id_Musique) REFERENCES Musique (id_Musique)
        );
        
        CREATE TABLE Musique (
            id_Musique           INTEGER PRIMARY KEY AUTOINCREMENT,
            nom_Musique          TEXT,
            genre_Musique        TEXT,
            interprete_Musique   TEXT,
            Compositeur_Musique  TEXT,
            annee_Sortie_Musique TEXT
        );
        
        CREATE TABLE Noter (
            id_Utilisateur INTEGER NOT NULL,
            id_Album       INTEGER NOT NULL,
            note           TEXT,
            PRIMARY KEY (id_Utilisateur, id_Album),
            FOREIGN KEY (id_Album) REFERENCES Album (id_Album),
            FOREIGN KEY (id_Utilisateur) REFERENCES Utilisateur (id_Utilisateur)
        );
        
        CREATE TABLE Playlist (
            id_Playlist INTEGER PRIMARY KEY AUTOINCREMENT,
            nom_Playlist TEXT,
            img_Playlist TEXT
        );
        
        CREATE TABLE Renfermer (
            id_Playlist INTEGER,
            id_Musique  INTEGER,
            PRIMARY KEY (id_Playlist, id_Musique),
            FOREIGN KEY (id_Musique) REFERENCES Musique (id_Musique),
            FOREIGN KEY (id_Playlist) REFERENCES Playlist (id_Playlist)
        );
        
        CREATE TABLE Utilisateur (
            id_Utilisateur  INTEGER PRIMARY KEY AUTOINCREMENT,
            nom_Utilisateur TEXT,
            mdp_Utilisateur TEXT,
            img_Utilisateur TEXT
        );
        
        CREATE TABLE Admin (
            id_Adm INTEGER PRIMARY KEY AUTOINCREMENT,
            nom_Adm TEXT,
            mdp_Adm TEXT
        );
      
          
        
        EOF;
        break;

    case 'delete-tables':
        echo '→ Go delete tables' . PHP_EOL;
        $sqlScript = <<<EOF
    DROP TABLE IF EXISTS Admin;
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

EOF;
        break;

        case 'load-data':
            echo '→ Go load data to tables' . PHP_EOL;
    
            
            $yamlFile = realpath(__DIR__ . '/../yaml/extrait.yml');
    
            if (file_exists($yamlFile)) {
                $data = recupInformations($yamlFile); // Utilisez yaml_parse pour analyser le fichier YAML
    
                if (isset($data) && is_array($data)) {
                    foreach ($data as $entry) {
                      $stmt = $pdo->prepare("INSERT INTO Album VALUES (NULL,:titre, :genre, :annee, :img)");
                      $stmt->execute([
                          'titre' => $entry['title'],
                          'genre' => $entry['genre'],
                          'annee' => $entry['releaseYear'],
                          'img' => ($entry['img'] !== 'null') ? $entry['img'] : 'default.png'
                      ]);

                      // Récupération de l'id de l'album inséré
                      $idAlbum = $pdo->lastInsertId();

                      // Insertion dans la table "Artistes"
                      $stmtArtiste = $pdo->prepare("INSERT INTO Artistes (nom_Artistes, img_Artistes) VALUES (:nom, :img)");
                      $stmtArtiste->execute([':nom' => $entry['by'], ':img' => 'default.png']);

                      // Récupération de l'id de l'artiste inséré
                      $idArtiste = $pdo->lastInsertId();

                      // Insertion dans la table de liaison "Creer"
                      $stmtCreer = $pdo->prepare("INSERT INTO Creer (id_Artistes, id_Album) VALUES (:id_Art, :id_Alb)");
                      $stmtCreer->execute([':id_Art' => $idArtiste, ':id_Alb' => $idAlbum]);

                      
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
        case 'insert';
            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, genre_Musique, interprete_Musique, Compositeur_Musique, annee_Sortie_Musique) values(:id_Musique, :nom_Musique, :genre_Musique, :interprete_Musique, :Compositeur_Musique, :annee_Sortie_Musique)');
            $stmt->execute([':nom_Musique' => 'Mignon tout plein', ':genre_Musique' => 'Rap', ':interprete_Musique' => 'PLK', ':Compositeur_Musique' => 'mdr', ':annee_Sortie_Musique' => '2024']);
            $stmt = $pdo->prepare('INSERT INTO Renfermer (id_Playlist, id_Musique) values(:id_Playlist, :id_Musique)');
            $stmt->execute([':id_Playlist' => '1', ':id_Musique' => '1']);
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

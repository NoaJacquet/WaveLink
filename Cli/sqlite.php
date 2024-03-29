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
          
              $album[$cle] = trim($valeur);
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
            nom_Genre TEXT,
            img_Genre TEXT
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
            url_Musique          TEXT
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
            img_Utilisateur TEXT,
            role TEXT
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

                    // ...

                    foreach ($data as $entry) {

                        // Insérer l'album avec le genre
                        $stmtAlbum = $pdo->prepare("INSERT INTO Album (titre_Album, annee_Sortie, img_Album) VALUES (:titre, :annee, :img)");
                        $stmtAlbum->execute([
                            'titre' => $entry['title'],
                            'annee' => $entry['releaseYear'],
                            'img' => ($entry['img'] !== 'null') ? $entry['img'] : 'default.jpg'
                        ]);

                        // Récupération de l'id de l'album inséré
                        $idAlbum = $pdo->lastInsertId();
                        

                        $genres = explode(',', trim($entry['genre'], '[]'));

                        // Pour chaque genre dans la liste
                        foreach ($genres as $genre) {
                            $genre = trim($genre);
                            if (!empty($genre)){
                                
                                // Vérification et insertion du genre
                                $stmtGenreCheck = $pdo->prepare("SELECT id_Genre FROM Genre WHERE nom_Genre = :genre");
                                $stmtGenreCheck->execute([':genre' => $genre]);
                                $genreRow = $stmtGenreCheck->fetch(PDO::FETCH_ASSOC);

                                if (!$genreRow) {
                                    // Le genre n'existe pas, l'insérer
                                    $stmtInsertGenre = $pdo->prepare("INSERT INTO Genre (nom_Genre, img_Genre) VALUES (:genre, :img)");
                                    $stmtInsertGenre->execute([':genre' => $genre, ':img'=> 'default.jpg']);
                                    $idGenre = $pdo->lastInsertId();
                                } else {
                                    // Le genre existe, récupérer son ID
                                    $idGenre = $genreRow['id_Genre'];
                                }


                                // Insertion dans la table de liaison "Appartenir"
                                $stmtAppartenir = $pdo->prepare("INSERT INTO Appartenir (id_Genre, id_Album) VALUES (:id_Genre, :id_Album)");
                                $stmtAppartenir->execute([':id_Genre' => $idGenre, ':id_Album' => $idAlbum]);

                                // Ajoutez des déclarations INSERT similaires pour les autres tables au besoin
                            }

                            
                        }

                        // Vérification et insertion de l'artiste
                        $stmtArtisteCheck = $pdo->prepare("SELECT id_Artistes FROM Artistes WHERE nom_Artistes = :nom");
                        $stmtArtisteCheck->execute([':nom' => $entry['by']]);
                        $artisteRow = $stmtArtisteCheck->fetch(PDO::FETCH_ASSOC);

                        if (!$artisteRow) {
                            // L'artiste n'existe pas, l'insérer
                            $stmtInsertArtiste = $pdo->prepare("INSERT INTO Artistes (nom_Artistes, img_Artistes) VALUES (:nom, :img)");
                            $stmtInsertArtiste->execute([':nom' => $entry['by'], ':img' => 'default.jpg']);
                            $idArtiste = $pdo->lastInsertId();
                        } else {
                            // L'artiste existe, récupérer son ID
                            $idArtiste = $artisteRow['id_Artistes'];
                        }

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
            $stmt = $pdo->prepare('INSERT INTO Utilisateur (nom_Utilisateur, mdp_Utilisateur, img_Utilisateur, role) VALUES (:nom_Utilisateur, :mdp_Utilisateur, :img_Utilisateur, :role)');
            $stmt->execute([
                ':nom_Utilisateur' => 'adm',
                ':mdp_Utilisateur' => 'adm', 
                ':img_Utilisateur' => 'default.jpg',
                ':role' => 'admin'
            ]);

            $stmt = $pdo->prepare('INSERT INTO Utilisateur (nom_Utilisateur, mdp_Utilisateur, img_Utilisateur, role) VALUES (:nom_Utilisateur, :mdp_Utilisateur, :img_Utilisateur, :role)');
            $stmt->execute([
                ':nom_Utilisateur' => 'ethan',
                ':mdp_Utilisateur' => 'ethan', // Vous devriez toujours hacher les mots de passe
                ':img_Utilisateur' => 'default.jpg',
                ':role' => 'user'
            ]);

            $stmt = $pdo->prepare('INSERT INTO Playlist (id_Playlist, nom_Playlist, img_Playlist) values(NULL, :nom_Playlist, :img_Playlist)');
            $stmt->execute([':nom_Playlist' => 'Favoris', ':img_Playlist' => 'favoris.png' ]);

            $stmt = $pdo->prepare('INSERT INTO Avoir (id_Playlist, id_Utilisateur) values(:id_Playlist, :id_Utilisateur)');
            $stmt->execute([':id_Playlist' => '1', ':id_Utilisateur' => '2' ]);

            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, url_Musique) values(:id_Musique, :nom_Musique, :url_Musique)');
            $stmt->execute([':nom_Musique' => 'Mignon tout plein', ':url_Musique' => 'e' ]);

            $stmt = $pdo->prepare('INSERT INTO Renfermer (id_Playlist, id_Musique) values(:id_Playlist, :id_Musique)');
            $stmt->execute([':id_Playlist' => '1', ':id_Musique' => '2' ]);

            $stmt = $pdo->prepare('INSERT INTO Genre (id_Genre, nom_Genre) values(:id_Genre, :nom_Genre)');
            $stmt->execute([':nom_Genre' => 'Jazz']);

            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, url_Musique) values(:id_Musique, :nom_Musique, :url_Musique)');
            $stmt->execute([':nom_Musique' => '(argument with david rawlings concerning morrissey)', ':url_Musique' => '' ]);

            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, url_Musique) values(:id_Musique, :nom_Musique, :url_Musique)');
            $stmt->execute([':nom_Musique' => 'to be young (is to be sad, is to be high)', ':url_Musique' => 'e' ]);

            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, url_Musique) values(:id_Musique, :nom_Musique, :url_Musique)');
            $stmt->execute([':nom_Musique' => 'my winding wheel', ':url_Musique' => 'e' ]);

            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, url_Musique) values(:id_Musique, :nom_Musique, :url_Musique)');
            $stmt->execute([':nom_Musique' => 'amy', ':url_Musique' => 'e' ]);

            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, url_Musique) values(:id_Musique, :nom_Musique, :url_Musique)');
            $stmt->execute([':nom_Musique' => 'oh my sweet carolina', ':url_Musique' => 'e' ]);

            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, url_Musique) values(:id_Musique, :nom_Musique, :url_Musique)');
            $stmt->execute([':nom_Musique' => 'bartering lines', ':url_Musique' => 'e' ]);

            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, url_Musique) values(:id_Musique, :nom_Musique, :url_Musique)');
            $stmt->execute([':nom_Musique' => 'call me on your way back home', ':url_Musique' => 'e' ]);

            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, url_Musique) values(:id_Musique, :nom_Musique, :url_Musique)');
            $stmt->execute([':nom_Musique' => 'damn, sam (i love a woman that rains)', ':url_Musique' => 'e' ]);

            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, url_Musique) values(:id_Musique, :nom_Musique, :url_Musique)');
            $stmt->execute([':nom_Musique' => 'come pick me up', ':url_Musique' => 'e' ]);

            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, url_Musique) values(:id_Musique, :nom_Musique, :url_Musique)');
            $stmt->execute([':nom_Musique' => 'to be the one', ':url_Musique' => 'e' ]);

            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, url_Musique) values(:id_Musique, :nom_Musique, :url_Musique)');
            $stmt->execute([':nom_Musique' => 'why do they leave?', ':url_Musique' => 'e' ]);

            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, url_Musique) values(:id_Musique, :nom_Musique, :url_Musique)');
            $stmt->execute([':nom_Musique' => 'shakedown on 9th street', ':url_Musique' => 'e' ]);

            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, url_Musique) values(:id_Musique, :nom_Musique, :url_Musique)');
            $stmt->execute([':nom_Musique' => "don't ask for the water", ':url_Musique' => 'e' ]);

            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, url_Musique) values(:id_Musique, :nom_Musique, :url_Musique)');
            $stmt->execute([':nom_Musique' => 'in my time of need', ':url_Musique' => 'e' ]);

            $stmt = $pdo->prepare('INSERT INTO Musique (id_Musique, nom_Musique, url_Musique) values(:id_Musique, :nom_Musique, :url_Musique)');
            $stmt->execute([':nom_Musique' => 'sweet lil gal (23rd/1st)', ':url_Musique' => 'e' ]);

            $stmt = $pdo->prepare('INSERT INTO Contenir (id_Album, id_Musique) values(:id_Album, :id_Musique)');
            $stmt->execute([':id_Album' => '3', ':id_Musique' => '2' ]);

            $stmt = $pdo->prepare('INSERT INTO Contenir (id_Album, id_Musique) values(:id_Album, :id_Musique)');
            $stmt->execute([':id_Album' => '3', ':id_Musique' => '3' ]);

            $stmt = $pdo->prepare('INSERT INTO Contenir (id_Album, id_Musique) values(:id_Album, :id_Musique)');
            $stmt->execute([':id_Album' => '3', ':id_Musique' => '4' ]);

            $stmt = $pdo->prepare('INSERT INTO Contenir (id_Album, id_Musique) values(:id_Album, :id_Musique)');
            $stmt->execute([':id_Album' => '3', ':id_Musique' => '5' ]);

            $stmt = $pdo->prepare('INSERT INTO Contenir (id_Album, id_Musique) values(:id_Album, :id_Musique)');
            $stmt->execute([':id_Album' => '3', ':id_Musique' => '6' ]);

            $stmt = $pdo->prepare('INSERT INTO Contenir (id_Album, id_Musique) values(:id_Album, :id_Musique)');
            $stmt->execute([':id_Album' => '3', ':id_Musique' => '7' ]);

            $stmt = $pdo->prepare('INSERT INTO Contenir (id_Album, id_Musique) values(:id_Album, :id_Musique)');
            $stmt->execute([':id_Album' => '3', ':id_Musique' => '8' ]);

            $stmt = $pdo->prepare('INSERT INTO Contenir (id_Album, id_Musique) values(:id_Album, :id_Musique)');
            $stmt->execute([':id_Album' => '3', ':id_Musique' => '9' ]);

            $stmt = $pdo->prepare('INSERT INTO Contenir (id_Album, id_Musique) values(:id_Album, :id_Musique)');
            $stmt->execute([':id_Album' => '3', ':id_Musique' => '10' ]);

            $stmt = $pdo->prepare('INSERT INTO Contenir (id_Album, id_Musique) values(:id_Album, :id_Musique)');
            $stmt->execute([':id_Album' => '3', ':id_Musique' => '11' ]);

            $stmt = $pdo->prepare('INSERT INTO Contenir (id_Album, id_Musique) values(:id_Album, :id_Musique)');
            $stmt->execute([':id_Album' => '3', ':id_Musique' => '12' ]);

            $stmt = $pdo->prepare('INSERT INTO Contenir (id_Album, id_Musique) values(:id_Album, :id_Musique)');
            $stmt->execute([':id_Album' => '3', ':id_Musique' => '13' ]);

            $stmt = $pdo->prepare('INSERT INTO Contenir (id_Album, id_Musique) values(:id_Album, :id_Musique)');
            $stmt->execute([':id_Album' => '3', ':id_Musique' => '14' ]);

            $stmt = $pdo->prepare('INSERT INTO Contenir (id_Album, id_Musique) values(:id_Album, :id_Musique)');
            $stmt->execute([':id_Album' => '3', ':id_Musique' => '15' ]);

            $stmt = $pdo->prepare('INSERT INTO Contenir (id_Album, id_Musique) values(:id_Album, :id_Musique)');
            $stmt->execute([':id_Album' => '3', ':id_Musique' => '16' ]);

            $stmt = $pdo->prepare('INSERT INTO Interpreter (id_Musique, id_Artistes) values(:id_Musique, :id_Artistes)');
            $stmt->execute([':id_Musique' => '2', ':id_Artistes' => '3' ]);

            $stmt = $pdo->prepare('INSERT INTO Interpreter (id_Musique, id_Artistes) values(:id_Musique, :id_Artistes)');
            $stmt->execute([':id_Musique' => '3', ':id_Artistes' => '3' ]);

            $stmt = $pdo->prepare('INSERT INTO Interpreter (id_Musique, id_Artistes) values(:id_Musique, :id_Artistes)');
            $stmt->execute([':id_Musique' => '4', ':id_Artistes' => '3' ]);

            $stmt = $pdo->prepare('INSERT INTO Interpreter (id_Musique, id_Artistes) values(:id_Musique, :id_Artistes)');
            $stmt->execute([':id_Musique' => '5', ':id_Artistes' => '3' ]);

            $stmt = $pdo->prepare('INSERT INTO Interpreter (id_Musique, id_Artistes) values(:id_Musique, :id_Artistes)');
            $stmt->execute([':id_Musique' => '6', ':id_Artistes' => '3' ]);

            $stmt = $pdo->prepare('INSERT INTO Interpreter (id_Musique, id_Artistes) values(:id_Musique, :id_Artistes)');
            $stmt->execute([':id_Musique' => '7', ':id_Artistes' => '3' ]);

            $stmt = $pdo->prepare('INSERT INTO Interpreter (id_Musique, id_Artistes) values(:id_Musique, :id_Artistes)');
            $stmt->execute([':id_Musique' => '8', ':id_Artistes' => '3' ]);

            $stmt = $pdo->prepare('INSERT INTO Interpreter (id_Musique, id_Artistes) values(:id_Musique, :id_Artistes)');
            $stmt->execute([':id_Musique' => '9', ':id_Artistes' => '3' ]);

            $stmt = $pdo->prepare('INSERT INTO Interpreter (id_Musique, id_Artistes) values(:id_Musique, :id_Artistes)');
            $stmt->execute([':id_Musique' => '10', ':id_Artistes' => '3' ]);

            $stmt = $pdo->prepare('INSERT INTO Interpreter (id_Musique, id_Artistes) values(:id_Musique, :id_Artistes)');
            $stmt->execute([':id_Musique' => '11', ':id_Artistes' => '3' ]);

            $stmt = $pdo->prepare('INSERT INTO Interpreter (id_Musique, id_Artistes) values(:id_Musique, :id_Artistes)');
            $stmt->execute([':id_Musique' => '12', ':id_Artistes' => '3' ]);

            $stmt = $pdo->prepare('INSERT INTO Interpreter (id_Musique, id_Artistes) values(:id_Musique, :id_Artistes)');
            $stmt->execute([':id_Musique' => '13', ':id_Artistes' => '3' ]);

            $stmt = $pdo->prepare('INSERT INTO Interpreter (id_Musique, id_Artistes) values(:id_Musique, :id_Artistes)');
            $stmt->execute([':id_Musique' => '14', ':id_Artistes' => '3' ]);

            $stmt = $pdo->prepare('INSERT INTO Interpreter (id_Musique, id_Artistes) values(:id_Musique, :id_Artistes)');
            $stmt->execute([':id_Musique' => '15', ':id_Artistes' => '3' ]);

            $stmt = $pdo->prepare('INSERT INTO Interpreter (id_Musique, id_Artistes) values(:id_Musique, :id_Artistes)');
            $stmt->execute([':id_Musique' => '16', ':id_Artistes' => '3' ]);

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

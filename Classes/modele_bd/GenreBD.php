<?php

// GenreBD.php

namespace modele_bd;

use modele\Artistes;
use modele\Genre;
use modele\Album;

class GenreBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllGenres() {
        $query = "SELECT * FROM Genre";
        $result = $this->connexion->query($query);

        $genres = [];
        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
            $genre = new Genre(
                $row['id_Genre'],
                $row['nom_Genre'],
                $row['img_Genre'],
            );
            $genres[] = $genre;
        }

        return $genres;
    }

    public function insertGenre($nomGenre, $imgGenre) {
        $query = "INSERT INTO Genre (nom_Genre, img_Genre) 
              VALUES (:nom, :img)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':nom', $nomGenre);
        $stmt->bindParam(':img', $imgGenre);

        return $stmt->execute();
    }

    public function deleteGenre($idGenre, $img_Genre) {
        $successMessage = "Le genre a été supprimé avec succès.";
        $failureMessage = "Échec de la suppression du genre.";
    
        if ($img_Genre !== 'default.jpg') {
            // Supprimer l'image associée au genre
            $imagePath = "images/" . $img_Genre; // Assurez-vous d'ajuster le chemin en fonction de votre structure
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    
        // Supprimer les relations dans la table Appartenir
        $queryAppartenir = "DELETE FROM Appartenir WHERE id_Genre = :idGenre";
        $stmtAppartenir = $this->connexion->prepare($queryAppartenir);
        $stmtAppartenir->bindParam(':idGenre', $idGenre, \PDO::PARAM_INT);
        $appartenirSuccess = $stmtAppartenir->execute();
    
        // Supprimer le genre de la table Genre
        $queryGenre = "DELETE FROM Genre WHERE id_Genre = :idGenre";
        $stmtGenre = $this->connexion->prepare($queryGenre);
        $stmtGenre->bindParam(':idGenre', $idGenre, \PDO::PARAM_INT);
        $genreSuccess = $stmtGenre->execute();
    
        // Vérifier le résultat des opérations
        if ($appartenirSuccess && $genreSuccess) {
            return $successMessage;
        } else {
            return $failureMessage;
        }
    }
    

    public function getAlbumByIdGenre($id) {
        $les_albums = array();
            try{
                $req = $this->connexion->prepare('SELECT id_Album, titre_Album, annee_Sortie, img_Album FROM Album natural join Appartenir WHERE id_Genre = :id');
                $req->execute(array('id'=>$id));
                $result = $req->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($result as $album){
                    array_push($les_albums, new Album($album['id_Album'], $album['titre_Album'],  $album['annee_Sortie'], $album['img_Album']));
                }
                return $les_albums;
            }catch (\PDOException $e) {
                var_dump($e->getMessage());
                return false;
            }
        }

    public function getArtistesByIdGenre($id) {
        $les_artistes = array();
            try{
                $req = $this->connexion->prepare('SELECT DISTINCT id_Artistes, nom_Artistes, img_Artistes FROM Artistes natural join Creer natural join Album natural join Appartenir WHERE id_Genre = :id');
                $req->execute(array('id'=>$id));
                $result = $req->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($result as $artistes){
                    array_push($les_artistes, new Artistes($artistes['id_Artistes'], $artistes['nom_Artistes'],  $artistes['img_Artistes']));
                }
                return $les_artistes;
            }catch (\PDOException $e) {
                var_dump($e->getMessage());
                return false;
            }
        }   
    // Ajoutez d'autres méthodes selon vos besoins
    public function getGenreById($idGenre) {
        $query = "SELECT * FROM Genre WHERE id_Genre = :idGenre";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idGenre', $idGenre, \PDO::PARAM_INT);
        $stmt->execute();
    
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($row) {
            $genre = new Genre(
                $row['id_Genre'],
                $row['nom_Genre'],
                $row['img_Genre']
            );
    
            return $genre;
        } else {
            return null;
        }
    }
    
    public function getGenreByAlbumId($idAlbum) {
        try {
            $query = "SELECT g.id_Genre, g.nom_Genre, g.img_Genre 
                      FROM Genre g 
                      INNER JOIN Appartenir a ON g.id_Genre = a.id_Genre 
                      INNER JOIN Album al ON a.id_Album = al.id_Album 
                      WHERE al.id_Album = :idAlbum";
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':idAlbum', $idAlbum, \PDO::PARAM_INT);
            $stmt->execute();
            
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($row) {
                $genre = new Genre(
                    $row['id_Genre'],
                    $row['nom_Genre'],
                    $row['img_Genre']
                );
                return $genre;
            } else {
                return null; // Aucun genre trouvé pour cet album
            }
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
    }
    
}
    
    



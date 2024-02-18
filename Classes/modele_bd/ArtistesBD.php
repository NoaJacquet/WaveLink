<?php

// ArtistesBD.php

namespace modele_bd;

use modele\Artistes;

class ArtistesBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllArtists() {
        $query = "SELECT * FROM Artistes ORDER BY id_Artistes DESC";
        $result = $this->connexion->query($query);

        $artists = [];
        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
            $artist = new Artistes(
                $row['id_Artistes'],
                $row['nom_Artistes'],
                $row['img_Artistes']
            );
            $artists[] = $artist;
        }

        return $artists;
    }

    public function getArtistById($id) {
        $query = "SELECT * FROM Artistes WHERE id_Artistes = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            $artist = new Artistes(
                $row['id_Artistes'],
                $row['nom_Artistes'],
                $row['img_Artistes']
            );

            return $artist;
        } else {
            return null;
        }
    }

    public function insertArtist($nom_artiste, $img_artiste) {

        $query = "INSERT INTO Artistes (nom_Artistes, img_Artistes) 
                  VALUES (:nom, :img)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':nom', $nom_artiste);
        $stmt->bindParam(':img', $img_artiste);

        return $stmt->execute();
    }

    public function updateArtist(Artistes $artist) {
        $query = "UPDATE Artistes SET nom_Artistes = :nom, img_Artistes = :img 
                  WHERE id_Artistes = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':nom', $artist->getNomArtistes());
        $stmt->bindParam(':img', $artist->getImgArtistes());
        $stmt->bindParam(':id', $artist->getIdArtistes(), \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteArtist($id, $imgArtiste)
    {
        $successMessage = "L'artiste a été supprimé avec succès.";
        $failureMessage = "Échec de la suppression de l'artiste.";

        if ($imgArtiste !== 'default.jpg') {
            // Supprimer l'image associée à l'artiste
            $imagePath = "images/" . $imgArtiste; // Assurez-vous d'ajuster le chemin en fonction de votre structure
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        try {
            // Supprimer les dépendances dans la table Interpreter
            $queryInterpreter = "DELETE FROM Interpreter WHERE id_Artistes = :idArtistes";
            $stmtInterpreter = $this->connexion->prepare($queryInterpreter);
            $stmtInterpreter->bindParam(':idArtistes', $id, \PDO::PARAM_INT);
            $stmtInterpreter->execute();

            // Supprimer les dépendances dans la table Interpreter avec id_Musique spécifié
            $queryInterpreterMusique = "DELETE FROM Interpreter WHERE id_Artistes = :idArtistes";
            $stmtInterpreterMusique = $this->connexion->prepare($queryInterpreterMusique);
            $stmtInterpreterMusique->bindParam(':idArtistes', $id, \PDO::PARAM_INT);
            $stmtInterpreterMusique->execute();


            // Supprimer l'artiste de la table Artistes
            $queryArtist = "DELETE FROM Artistes WHERE id_Artistes = :idArtistes";
            $stmtArtist = $this->connexion->prepare($queryArtist);
            $stmtArtist->bindParam(':idArtistes', $id, \PDO::PARAM_INT);
            $stmtArtist->execute();

            return $successMessage;
        } catch (\Exception $e) {
            // En cas d'erreur, vous pouvez logguer l'exception ou gérer l'erreur de la manière appropriée
            return $e;
        }
    }



    

    public function getArtistByAlbumId($idAlbum) {
        $query = "SELECT a.*
                  FROM Artistes a
                  NATURAL JOIN Creer c
                  WHERE c.id_Album = :idAlbum";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum, \PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            $artist = new Artistes(
                $row['id_Artistes'],
                $row['nom_Artistes'],
                $row['img_Artistes']
            );

            return $artist;
        } else {
            return null;
        }
    }

    public function getArtistByMusiqueId($idMusique) {
        $query = "SELECT a.*
                  FROM Artistes a
                  NATURAL JOIN Interpreter i
                  WHERE i.id_Musique = :idMusique";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idMusique', $idMusique, \PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            $artist = new Artistes(
                $row['id_Artistes'],
                $row['nom_Artistes'],
                $row['img_Artistes']
            );

            return $artist;
        } else {
            return null;
        }
    }

    public function countArtistes() {
        try {
            $query = "SELECT COUNT(*) as total FROM Artistes";
            $stmt = $this->connexion->query($query);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
            if ($result) {
                return $result['total'];
            } else {
                return 0;
            }
        } catch (\PDOException $e) {
            // Vous pouvez logguer l'erreur au lieu de l'afficher directement
            error_log('Erreur lors du comptage des artistes : ' . $e->getMessage());
            return 0;
        }
    }

    public function getAllArtistsBis($m) {
        $query = "SELECT * FROM Artistes WHERE nom_Artistes LIKE :prefix ";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindValue(':prefix', $m . '%', \PDO::PARAM_STR);
        $stmt->execute();
    
        $artists = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $artist = new Artistes(
                $row['id_Artistes'],
                $row['nom_Artistes'],
                $row['img_Artistes']
            );
            $artists[] = $artist;
        }
    
        return $artists;
    }
    


}

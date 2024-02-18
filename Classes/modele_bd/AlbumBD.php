<?php

// AlbumBD.php
namespace modele_bd;

use modele\Album;

class  AlbumBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllAlbums() {
        $query = "SELECT * FROM Album ";
        $result = $this->connexion->query($query);

        $albums = [];
        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
            $album = new Album(
                $row['id_Album'],
                $row['titre_Album'],
                $row['annee_Sortie'],
                $row['img_Album']
            );
            $albums[] = $album;
        }

        return $albums;
    }

    public function getAlbumById($id) {
        $query = "SELECT * FROM Album WHERE id_Album = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            $album = new Album(
                $row['id_Album'],
                $row['titre_Album'],
                $row['annee_Sortie'],
                $row['img_Album']
            );

            return $album;
        } else {
            return null;
        }
    }

    public function insertAlbum($nomAlbum, $genresSelectionnes, $filename, $idArtiste, $annee) {
        $queryAlbum = "INSERT INTO Album (titre_Album, annee_Sortie, img_Album) 
                      VALUES (:titre, :annee, :img)";
        $stmtAlbum = $this->connexion->prepare($queryAlbum);
        $stmtAlbum->bindParam(':titre', $nomAlbum);
        // Vous pouvez ajouter l'année de sortie si vous en avez besoin
        // $stmtAlbum->bindParam(':annee', $annee);
        $stmtAlbum->bindParam(':img', $filename);
    
        $successAlbum = $stmtAlbum->execute();
    
        if ($successAlbum) {
            $idAlbum = $this->connexion->lastInsertId();
    
            $queryGenre = "INSERT INTO Appartenir (id_Album, id_Genre) VALUES (:idAlbum, :idGenre)";
            $stmtGenre = $this->connexion->prepare($queryGenre);
    
            foreach ($genresSelectionnes as $idGenre) {
                $stmtGenre->bindParam(':idAlbum', $idAlbum);
                $stmtGenre->bindParam(':idGenre', $idGenre);
                $stmtGenre->execute();
            }
    
            $queryCreer = "INSERT INTO Creer (id_Artistes, id_Album) VALUES (:idArtiste, :idAlbum)";
            $stmtCreer = $this->connexion->prepare($queryCreer);
            $stmtCreer->bindParam(':idAlbum', $idAlbum);
            $stmtCreer->bindParam(':idArtiste', $idArtiste);
            $stmtCreer->execute();
            
    
            return true;
        } else {
            return false;
        }
    }
    

    public function updateAlbum(Album $album) {
        $query = "UPDATE Album SET titre_Album = :titre, 
                  annee_Sortie = :annee, img_Album = :img WHERE id_Album = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':titre', $album->getTitreAlbum());
        $stmt->bindParam(':annee', $album->getAnneeSortie());
        $stmt->bindParam(':img', $album->getImgAlbum());
        $stmt->bindParam(':id', $album->getIdAlbum(), \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteAlbum($id, $imgAlbum) {
        $successMessage = "L'album a été supprimé avec succès.";
        $failureMessage = "Échec de la suppression de l'album.";
    
        if ($imgAlbum !== 'default.jpg') {
            // Supprimer l'image associée à l'album
            $imagePath = "images/" . $imgAlbum; // Assurez-vous d'ajuster le chemin en fonction de votre structure
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    
        // Supprimer les dépendances dans la table Creer
        $queryCreer = "DELETE FROM Creer WHERE id_Album = :idAlbum";
        $stmtCreer = $this->connexion->prepare($queryCreer);
        $stmtCreer->bindParam(':idAlbum', $id, \PDO::PARAM_INT);
        $stmtCreer->execute();
    
        // Supprimer les dépendances dans la table Noter
        $queryNoter = "DELETE FROM Noter WHERE id_Album = :idAlbum";
        $stmtNoter = $this->connexion->prepare($queryNoter);
        $stmtNoter->bindParam(':idAlbum', $id, \PDO::PARAM_INT);
        $stmtNoter->execute();
    
        // Supprimer les dépendances dans la table Appartenir
        $queryAppartenir = "DELETE FROM Appartenir WHERE id_Album = :idAlbum";
        $stmtAppartenir = $this->connexion->prepare($queryAppartenir);
        $stmtAppartenir->bindParam(':idAlbum', $id, \PDO::PARAM_INT);
        $stmtAppartenir->execute();
    
        // Supprimer les dépendances dans la table Contenir
        $queryContenir = "DELETE FROM Contenir WHERE id_Album = :idAlbum";
        $stmtContenir = $this->connexion->prepare($queryContenir);
        $stmtContenir->bindParam(':idAlbum', $id, \PDO::PARAM_INT);
        $stmtContenir->execute();
    
        // Supprimer l'album de la table Album
        $queryAlbum = "DELETE FROM Album WHERE id_Album = :idAlbum";
        $stmtAlbum = $this->connexion->prepare($queryAlbum);
        $stmtAlbum->bindParam(':idAlbum', $id, \PDO::PARAM_INT);
    
        // Vérifier le résultat des opérations
        if ($stmtAlbum->execute()) {
            return $successMessage;
        } else {
            return $failureMessage;
        }
    }
    

    public function getAlbumsByArtistId($artistId) {
        $query = "SELECT Album.id_Album, Album.titre_Album, Album.annee_Sortie, Album.img_Album
                  FROM Album
                  JOIN Creer ON Album.id_Album = Creer.id_Album
                  WHERE Creer.id_Artistes = :artistId";
    
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':artistId', $artistId, \PDO::PARAM_INT);
        $stmt->execute();
    
        $albums = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $album = new Album(
                $row['id_Album'],
                $row['titre_Album'],
                $row['annee_Sortie'],
                $row['img_Album']
            );
            $albums[] = $album;
        }
    
        return $albums;
    }

    public function getAlbumByMusicId($musicId) {
        $query = "SELECT a.*
                  FROM Album a
                  NATURAL JOIN Contenir
                  WHERE Contenir.id_Musique = :musicId";
    
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':musicId', $musicId, \PDO::PARAM_INT);
        $stmt->execute();
    
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($row) {
            $album = new Album(
                $row['id_Album'],
                $row['titre_Album'],
                $row['annee_Sortie'],
                $row['img_Album']
            );
    
            return $album;
        } else {
            return null;
        }
    }

    public function countAlbums() {
        try {
            $query = "SELECT COUNT(*) as total FROM Album";
            $stmt = $this->connexion->query($query);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
            if ($result) {
                return $result['total'];
            } else {
                return 0;
            }
        } catch (\PDOException $e) {
            // Vous pouvez logguer l'erreur au lieu de l'afficher directement
            error_log('Erreur lors du comptage des albums : ' . $e->getMessage());
            return 0;
        }
    }

    public function getAllAlbumsBis($m) {
        $query = "SELECT * FROM Album WHERE titre_Album LIKE :prefix";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindValue(':prefix', $m . '%', \PDO::PARAM_STR);
        $stmt->execute();
    
        $albums = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $album = new Album(
                $row['id_Album'],
                $row['titre_Album'],
                $row['annee_Sortie'],
                $row['img_Album']
            );
            $albums[] = $album;
        }
    
        return $albums;
    }
    
    

    
    
}

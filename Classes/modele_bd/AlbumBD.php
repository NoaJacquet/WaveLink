<?php

// AlbumBD.php
namespace modele_bd;

use modele\Album;

class AlbumBD {
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

    public function insertAlbum(Album $album) {
        $query = "INSERT INTO Album (titre_Album, annee_Sortie, img_Album) 
                  VALUES (:titre, :annee, :img)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':titre', $album->getTitreAlbum());
        $stmt->bindParam(':annee', $album->getAnneeSortie());
        $stmt->bindParam(':img', $album->getImgAlbum());

        return $stmt->execute();
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

    public function deleteAlbum($id) {
        $query = "DELETE FROM Album WHERE id_Album = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        return $stmt->execute();
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
    
}

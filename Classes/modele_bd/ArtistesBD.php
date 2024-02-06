<?php

// ArtistesBD.php

// modele_bd/ArtistesBD.php
require_once 'Chemin/vers/la/classe/Artistes.php';

class ArtistesBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllArtists() {
        $query = "SELECT * FROM Artistes";
        $result = $this->connexion->query($query);

        $artists = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
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
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

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

    public function insertArtist(Artistes $artist) {
        $query = "INSERT INTO Artistes (nom_Artistes, img_Artistes) 
                  VALUES (:nom, :img)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':nom', $artist->getNomArtistes());
        $stmt->bindParam(':img', $artist->getImgArtistes());

        return $stmt->execute();
    }

    public function updateArtist(Artistes $artist) {
        $query = "UPDATE Artistes SET nom_Artistes = :nom, img_Artistes = :img 
                  WHERE id_Artistes = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':nom', $artist->getNomArtistes());
        $stmt->bindParam(':img', $artist->getImgArtistes());
        $stmt->bindParam(':id', $artist->getIdArtistes(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteArtist($id) {
        $query = "DELETE FROM Artistes WHERE id_Artistes = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

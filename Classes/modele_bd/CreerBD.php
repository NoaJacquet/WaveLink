<?php

// CreerBD.php

// modele_bd/CreerBD.php
require_once 'Chemin/vers/la/classe/Creer.php';

class CreerBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllCreers() {
        $query = "SELECT * FROM Creer";
        $result = $this->connexion->query($query);

        $creers = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $creer = new Creer(
                $row['id_Artistes'],
                $row['id_Album']
            );
            $creers[] = $creer;
        }

        return $creers;
    }

    public function insertCreer(Creer $creer) {
        $query = "INSERT INTO Creer (id_Artistes, id_Album) 
                  VALUES (:idArtistes, :idAlbum)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idArtistes', $creer->getIdArtistes(), PDO::PARAM_INT);
        $stmt->bindParam(':idAlbum', $creer->getIdAlbum(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteCreer($idArtistes, $idAlbum) {
        $query = "DELETE FROM Creer WHERE id_Artistes = :idArtistes AND id_Album = :idAlbum";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idArtistes', $idArtistes, PDO::PARAM_INT);
        $stmt->bindParam(':idAlbum', $idAlbum, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Ajoutez d'autres méthodes selon vos besoins
}

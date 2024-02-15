<?php

// ContenirBD.php

namespace modele_bd;

use modele\Contenir;

class ContenirBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllContenirs() {
        $query = "SELECT * FROM Contenir";
        $result = $this->connexion->query($query);

        $contenirs = [];
        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
            $contenir = new Contenir(
                $row['id_Album'],
                $row['id_Musique']
            );
            $contenirs[] = $contenir;
        }

        return $contenirs;
    }

    public function insertContenir($idAlbum, $idMusique) {
        $query = "INSERT INTO Contenir (id_Album, id_Musique) 
                  VALUES (:idAlbum, :idMusique)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum, \PDO::PARAM_INT);
        $stmt->bindParam(':idMusique', $idMusique, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteContenir($idAlbum, $idMusique) {
        $query = "DELETE FROM Contenir WHERE id_Album = :idAlbum AND id_Musique = :idMusique";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum, \PDO::PARAM_INT);
        $stmt->bindParam(':idMusique', $idMusique, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Ajoutez d'autres méthodes selon vos besoins
}

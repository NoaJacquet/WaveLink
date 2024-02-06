<?php

// AppartenirBD.php

namespace modele_bd;

use modele\Appartenir;

class AppartenirBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllAppartenirs() {
        $query = "SELECT * FROM Appartenir";
        $result = $this->connexion->query($query);

        $appartenirs = [];
        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
            $appartenir = new Appartenir(
                $row['id_Genre'],
                $row['id_Album']
            );
            $appartenirs[] = $appartenir;
        }

        return $appartenirs;
    }

    public function insertAppartenir(Appartenir $appartenir) {
        $query = "INSERT INTO Appartenir (id_Genre, id_Album) 
                  VALUES (:idGenre, :idAlbum)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idGenre', $appartenir->getIdGenre());
        $stmt->bindParam(':idAlbum', $appartenir->getIdAlbum());

        return $stmt->execute();
    }

    public function deleteAppartenir($idGenre, $idAlbum) {
        $query = "DELETE FROM Appartenir WHERE id_Genre = :idGenre AND id_Album = :idAlbum";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idGenre', $idGenre, \PDO::PARAM_INT);
        $stmt->bindParam(':idAlbum', $idAlbum, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Ajoutez d'autres méthodes selon vos besoins
}

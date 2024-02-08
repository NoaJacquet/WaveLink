<?php

// ComposerBD.php

namespace modele_bd;

use modele\Composer;

class ComposerBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllComposers() {
        $query = "SELECT * FROM Composer";
        $result = $this->connexion->query($query);

        $composers = [];
        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
            $composer = new Composer(
                $row['id_Musique'],
                $row['id_Artistes']
            );
            $composers[] = $composer;
        }

        return $composers;
    }

    public function insertComposer(Composer $composer) {
        $query = "INSERT INTO Composer (id_Musique, id_Artistes) 
                  VALUES (:idMusique, :idArtistes)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idMusique', $composer->getIdMusique(), \PDO::PARAM_INT);
        $stmt->bindParam(':idArtistes', $composer->getIdArtistes(), \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteComposer($idMusique, $idArtistes) {
        $query = "DELETE FROM Composer WHERE id_Musique = :idMusique AND id_Artistes = :idArtistes";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idMusique', $idMusique, \PDO::PARAM_INT);
        $stmt->bindParam(':idArtistes', $idArtistes, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Ajoutez d'autres méthodes selon vos besoins
}

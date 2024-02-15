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
        // Vérifier si le duo id_Musique et id_Album existe déjà
        $queryCheck = "SELECT COUNT(*) FROM Contenir WHERE id_Album = :idAlbum AND id_Musique = :idMusique";
        $stmtCheck = $this->connexion->prepare($queryCheck);
        $stmtCheck->bindParam(':idAlbum', $idAlbum, \PDO::PARAM_INT);
        $stmtCheck->bindParam(':idMusique', $idMusique, \PDO::PARAM_INT);
        $stmtCheck->execute();
    
        $existingCount = $stmtCheck->fetchColumn();
    
        if ($existingCount > 0) {
            return "musique_existante";
        }
    
        // Si le duo n'existe pas, procéder à l'insertion
        $queryInsert = "INSERT INTO Contenir (id_Album, id_Musique) 
                        VALUES (:idAlbum, :idMusique)";
        $stmtInsert = $this->connexion->prepare($queryInsert);
        $stmtInsert->bindParam(':idAlbum', $idAlbum, \PDO::PARAM_INT);
        $stmtInsert->bindParam(':idMusique', $idMusique, \PDO::PARAM_INT);
    
        // Exécuter la requête d'insertion
        if ($stmtInsert->execute()) {
            return "L'insertion dans la table Contenir a été effectuée avec succès.";
        } else {
            return "Erreur lors de l'insertion dans la table Contenir.";
        }
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

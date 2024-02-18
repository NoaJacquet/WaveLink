<?php

// RenfermerBD.php

namespace modele_bd;

use modele\Renfermer;

class RenfermerBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllRenfermements() {
        $query = "SELECT * FROM Renfermer";
        $result = $this->connexion->query($query);

        $renfermements = [];
        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
            $renfermer = new Renfermer(
                $row['id_Playlist'],
                $row['id_Musique']
            );
            $renfermements[] = $renfermer;
        }

        return $renfermements;
    }

    public function insertRenfermer($idP, $idM) {
        $checkQuery = "SELECT COUNT(*) FROM Renfermer WHERE id_Playlist = :idPlaylist AND id_Musique = :idMusique";
        $checkStmt = $this->connexion->prepare($checkQuery);
        $checkStmt->bindParam(':idPlaylist', $idP, \PDO::PARAM_INT);
        $checkStmt->bindParam(':idMusique', $idM, \PDO::PARAM_INT);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn() > 0) {
            // Entry already exists, return duplicate indication
            return 'Duplicate entry';
        }

        $query = "INSERT INTO Renfermer (id_Playlist, id_Musique) 
                  VALUES (:idPlaylist, :idMusique)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idPlaylist', $idP, \PDO::PARAM_INT);
        $stmt->bindParam(':idMusique', $idM, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteRenfermer($idPlaylist, $idMusique) {
        $query = "DELETE FROM Renfermer WHERE id_Playlist = :idPlaylist AND id_Musique = :idMusique";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idPlaylist', $idPlaylist, \PDO::PARAM_INT);
        $stmt->bindParam(':idMusique', $idMusique, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Ajoutez d'autres méthodes selon vos besoins
}

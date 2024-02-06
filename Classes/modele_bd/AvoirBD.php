<?php

// AvoirBD.php

// modele_bd/AvoirBD.php
require_once 'Chemin/vers/la/classe/Avoir.php';

class AvoirBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllAvoirs() {
        $query = "SELECT * FROM Avoir";
        $result = $this->connexion->query($query);

        $avoirs = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $avoir = new Avoir(
                $row['id_Playlist'],
                $row['id_Utilisateur']
            );
            $avoirs[] = $avoir;
        }

        return $avoirs;
    }

    public function insertAvoir(Avoir $avoir) {
        $query = "INSERT INTO Avoir (id_Playlist, id_Utilisateur) 
                  VALUES (:idPlaylist, :idUtilisateur)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idPlaylist', $avoir->getIdPlaylist(), PDO::PARAM_INT);
        $stmt->bindParam(':idUtilisateur', $avoir->getIdUtilisateur(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteAvoir($idPlaylist, $idUtilisateur) {
        $query = "DELETE FROM Avoir WHERE id_Playlist = :idPlaylist AND id_Utilisateur = :idUtilisateur";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idPlaylist', $idPlaylist, PDO::PARAM_INT);
        $stmt->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Ajoutez d'autres méthodes selon vos besoins
}

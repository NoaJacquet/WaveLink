<?php

// RenfermerBD.php

// modele_bd/RenfermerBD.php
require_once 'Chemin/vers/la/classe/Renfermer.php';

class RenfermerBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllRenfermements() {
        $query = "SELECT * FROM Renfermer";
        $result = $this->connexion->query($query);

        $renfermements = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $renfermer = new Renfermer(
                $row['id_Playlist'],
                $row['id_Musique']
            );
            $renfermements[] = $renfermer;
        }

        return $renfermements;
    }

    public function insertRenfermer(Renfermer $renfermer) {
        $query = "INSERT INTO Renfermer (id_Playlist, id_Musique) 
                  VALUES (:idPlaylist, :idMusique)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idPlaylist', $renfermer->getIdPlaylist(), PDO::PARAM_INT);
        $stmt->bindParam(':idMusique', $renfermer->getIdMusique(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteRenfermer($idPlaylist, $idMusique) {
        $query = "DELETE FROM Renfermer WHERE id_Playlist = :idPlaylist AND id_Musique = :idMusique";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idPlaylist', $idPlaylist, PDO::PARAM_INT);
        $stmt->bindParam(':idMusique', $idMusique, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Ajoutez d'autres méthodes selon vos besoins
}

<?php

// NoterBD.php
namespace modele_bd;

use modele\Noter;

class NoterBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllNotes() {
        $query = "SELECT * FROM Noter";
        $result = $this->connexion->query($query);

        $notes = [];
        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
            $note = new Noter(
                $row['id_Utilisateur'],
                $row['id_Album'],
                $row['note']
            );
            $notes[] = $note;
        }

        return $notes;
    }

    public function insertNote(Noter $note) {
        $query = "INSERT INTO Noter (id_Utilisateur, id_Album, note) 
                  VALUES (:idUtilisateur, :idAlbum, :note)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idUtilisateur', $note->getIdUtilisateur(), \PDO::PARAM_INT);
        $stmt->bindParam(':idAlbum', $note->getIdAlbum(), \PDO::PARAM_INT);
        $stmt->bindParam(':note', $note->getNote());

        return $stmt->execute();
    }

    public function deleteNote($idUtilisateur, $idAlbum) {
        $query = "DELETE FROM Noter WHERE id_Utilisateur = :idUtilisateur AND id_Album = :idAlbum";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idUtilisateur', $idUtilisateur, \PDO::PARAM_INT);
        $stmt->bindParam(':idAlbum', $idAlbum, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Ajoutez d'autres méthodes selon vos besoins
}

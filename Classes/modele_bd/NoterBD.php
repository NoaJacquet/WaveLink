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

    public function calculerMoyenneNotesParAlbum($idAlbum) {
        // Requête pour obtenir la moyenne des notes pour un album spécifique
        $query = "SELECT AVG(note) AS moyenne FROM Noter WHERE id_Album = :idAlbum";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum, \PDO::PARAM_INT);
        
        $stmt->execute();

        $resultat = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        // Vérifie si la moyenne a été obtenue avec succès
        if ($resultat && isset($resultat['moyenne'])) {
            return $resultat['moyenne'];
        } else {
            return null; // Si aucun résultat n'est retourné
        }
    }
    
    public function getNoteAlbumById($idUtilisateur, $idAlbum) {
        // Requête pour récupérer la note d'un utilisateur sur un album spécifique
        $query = "SELECT note FROM Noter WHERE id_Utilisateur = :idUtilisateur AND id_Album = :idAlbum";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idUtilisateur', $idUtilisateur, \PDO::PARAM_INT);
        $stmt->bindParam(':idAlbum', $idAlbum, \PDO::PARAM_INT);
        
        // Exécute la requête
        $stmt->execute();
        
        // Récupère la note
        $resultat = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        // Vérifie si la note a été obtenue avec succès
        if ($resultat && isset($resultat['note'])) {
            return $resultat['note'];
        } else {
            return null; // Si aucun résultat n'est retourné
        }
    }
    
    // Ajoutez d'autres méthodes selon vos besoins
}

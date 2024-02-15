<?php

// MusiqueBD.php


namespace modele_bd;

use modele\Musique;

class MusiqueBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllMusiques() {
        $query = "SELECT * FROM Musique";
        $result = $this->connexion->query($query);

        $musiques = [];
        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
            $musique = new Musique(
                $row['id_Musique'],
                $row['nom_Musique'],
                $row['url_Musique']

            );
            $musiques[] = $musique;
        }

        return $musiques;
    }

    public function insertMusique($nomMusique, $musiqueFilename, $idArtiste) {
        $query = "INSERT INTO Musique (nom_Musique, url_Musique) 
                  VALUES (:nom, :fichier)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':nom', $nomMusique);
        $stmt->bindParam(':fichier', $musiqueFilename);
    
        $successMusique = $stmt->execute();
    
        if ($successMusique) {
            $idMusique = $this->connexion->lastInsertId();
    
            // Ajouter l'association entre la musique et l'artiste dans la table Interpreter
            $queryInterpreter = "INSERT INTO Interpreter (id_Musique, id_Artistes) 
                                  VALUES (:idMusique, :idArtiste)";
            $stmtInterpreter = $this->connexion->prepare($queryInterpreter);
            $stmtInterpreter->bindParam(':idMusique', $idMusique, \PDO::PARAM_INT);
            $stmtInterpreter->bindParam(':idArtiste', $idArtiste, \PDO::PARAM_INT);
    
            $successInterpreter = $stmtInterpreter->execute();
    
            if ($successInterpreter) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    

    public function deleteMusique($idMusique) {
        $query = "DELETE FROM Musique WHERE id_Musique = :idMusique";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idMusique', $idMusique, \PDO::PARAM_INT);

        return $stmt->execute();
    }


    public function getMusiquesByAlbumId($idAlbum) {
        $query = "SELECT m.* FROM Musique m
                  INNER JOIN Contenir c ON m.id_Musique = c.id_Musique
                  WHERE c.id_Album = :idAlbum";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idAlbum', $idAlbum, \PDO::PARAM_INT);
        $stmt->execute();

        $musiques = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $musique = new Musique(
                $row['id_Musique'],
                $row['nom_Musique'],
                $row['url_Musique']
            );
            $musiques[] = $musique;
        }

        return $musiques;
    }

    public function getMusiquesByArtistId($idArtiste) {

        $query = "SELECT m.* FROM Musique m
                  NATURAL JOIN Interpreter i
                  WHERE i.id_Artistes = :idArtiste";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idArtiste', $idArtiste, \PDO::PARAM_INT);
        $stmt->execute();

        $musiques = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $musique = new Musique(
                $row['id_Musique'],
                $row['nom_Musique'],
                $row['url_Musique']
            );
            $musiques[] = $musique;
        }

        return $musiques;
    }

    



    
    // Ajoutez d'autres méthodes selon vos besoins
}

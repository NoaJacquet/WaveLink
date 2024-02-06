<?php

// MusiqueBD.php


// modele_bd/MusiqueBD.php
require_once 'Chemin/vers/la/classe/Musique.php';

class MusiqueBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllMusiques() {
        $query = "SELECT * FROM Musique";
        $result = $this->connexion->query($query);

        $musiques = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $musique = new Musique(
                $row['id_Musique'],
                $row['nom_Musique'],
                $row['genre_Musique'],
                $row['interprete_Musique'],
                $row['Compositeur_Musique'],
                $row['annee_Sortie_Musique']
            );
            $musiques[] = $musique;
        }

        return $musiques;
    }

    public function insertMusique(Musique $musique) {
        $query = "INSERT INTO Musique (nom_Musique, genre_Musique, interprete_Musique, Compositeur_Musique, annee_Sortie_Musique) 
                  VALUES (:nom, :genre, :interprete, :compositeur, :anneeSortie)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':nom', $musique->getNomMusique());
        $stmt->bindParam(':genre', $musique->getGenreMusique());
        $stmt->bindParam(':interprete', $musique->getInterpreteMusique());
        $stmt->bindParam(':compositeur', $musique->getCompositeurMusique());
        $stmt->bindParam(':anneeSortie', $musique->getAnneeSortieMusique());

        return $stmt->execute();
    }

    public function deleteMusique($idMusique) {
        $query = "DELETE FROM Musique WHERE id_Musique = :idMusique";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idMusique', $idMusique, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Ajoutez d'autres méthodes selon vos besoins
}

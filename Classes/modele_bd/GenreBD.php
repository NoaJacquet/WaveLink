<?php

// GenreBD.php

// modele_bd/GenreBD.php
require_once 'Chemin/vers/la/classe/Genre.php';

class GenreBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllGenres() {
        $query = "SELECT * FROM Genre";
        $result = $this->connexion->query($query);

        $genres = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $genre = new Genre(
                $row['id_Genre'],
                $row['nom_Genre']
            );
            $genres[] = $genre;
        }

        return $genres;
    }

    public function insertGenre(Genre $genre) {
        $query = "INSERT INTO Genre (nom_Genre) 
                  VALUES (:nom)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':nom', $genre->getNomGenre());

        return $stmt->execute();
    }

    public function deleteGenre($idGenre) {
        $query = "DELETE FROM Genre WHERE id_Genre = :idGenre";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idGenre', $idGenre, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Ajoutez d'autres méthodes selon vos besoins
}

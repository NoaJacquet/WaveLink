<?php

// GenreBD.php

// modele_bd/GenreBD.php
namespace modele_bd;
use modele\Genre;
use modele\Album;

class GenreBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllGenres() {
        $query = "SELECT * FROM Genre";
        $result = $this->connexion->query($query);

        $genres = [];
        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
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
        $stmt->bindParam(':idGenre', $idGenre, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getAlbumByIdGenre($id) {
        $les_albums = array();
            try{
                $req = $this->connexion->prepare('SELECT id_Album, titre_Album, genre_Album, annee_Sortie, img_Album FROM Album natural join Appartenir WHERE id_Genre = :id');
                $req->execute(array('id'=>$id));
                $result = $req->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($result as $album){
                    array_push($les_albums, new Album($album['id_Album'], $album['titre_Album'], $album['genre_Album'], $album['annee_Sortie'], $album['img_Album']));
                }
                return $les_albums;
            }catch (\PDOException $e) {
                var_dump($e->getMessage());
                return false;
            }
        }

    // Ajoutez d'autres méthodes selon vos besoins
}

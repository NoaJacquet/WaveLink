<?php

// PlaylistBD.php
declare(strict_types= 1);
namespace modele_bd;
use modele\Playlist;
use modele\Musique;


class PlaylistBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllPlaylists() {
        $query = "SELECT * FROM Playlist";
        $result = $this->connexion->query($query);

        $playlists = [];
        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
            $playlist = new Playlist(
                $row['id_Playlist'],
                $row['nom_Playlist'],
                $row['img_Playlist']
            );
            $playlists[] = $playlist;
        }

        return $playlists;
    }

    public function getPlaylistById($id) {
        $query = "SELECT * FROM Playlist WHERE id_Playlist = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            $playlist = new Playlist(
                $row['id_Playlist'],
                $row['nom_Playlist'],
                $row['img_Playlist']
            );

            return $playlist;
        } else {
            return null;
        }
    }

    public function insertPlaylist(Playlist $playlist) {
        $query = "INSERT INTO Playlist (nom_Playlist, img_Playlist) 
                  VALUES (:nom, :img)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':nom', $playlist->getNomPlaylist());
        $stmt->bindParam(':img', $playlist->getImgPlaylist());

        return $stmt->execute();
    }

    public function updatePlaylist(Playlist $playlist) {
        $query = "UPDATE Playlist SET nom_Playlist = :nom, img_Playlist = :img 
                  WHERE id_Playlist = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':nom', $playlist->getNomPlaylist());
        $stmt->bindParam(':img', $playlist->getImgPlaylist());
        $stmt->bindParam(':id', $playlist->getIdPlaylist(), \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deletePlaylist($id) {
        $query = "DELETE FROM Playlist WHERE id_Playlist = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getSongByIdPlaylist($id) {
        $les_sons = array();
            try{
                $req = $this->connexion->prepare('SELECT id_Musique, nom_Musique, url_Musique FROM Musique natural join Renfermer WHERE id_Playlist = :id');
                $req->execute(array('id'=>$id));
                $result = $req->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($result as $musique){
                    array_push($les_sons, new Musique($musique['id_Musique'], $musique['nom_Musique'], $musique['url_Musique'],));
                }
                return $les_sons;
            }catch (\PDOException $e) {
                var_dump($e->getMessage());
                return false;
            }
    }

    public function getFavorisById($id) {
        $query = "SELECT p.* FROM Playlist p Natural join Avoir WHERE id_Utilisateur = :id and nom_Playlist = 'Favoris'";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            $playlist = new Playlist(
                $row['id_Playlist'],
                $row['nom_Playlist'],
                $row['img_Playlist']
            );

            return $playlist;
        } else {
            return null;
        }
    }
}

<?php

// PlaylistBD.php

// modele_bd/PlaylistBD.php
require_once 'Chemin/vers/la/classe/Playlist.php';

class PlaylistBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllPlaylists() {
        $query = "SELECT * FROM Playlist";
        $result = $this->connexion->query($query);

        $playlists = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
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
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

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
        $stmt->bindParam(':id', $playlist->getIdPlaylist(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deletePlaylist($id) {
        $query = "DELETE FROM Playlist WHERE id_Playlist = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

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

    public function getAllPlaylists($userId) {
        $query = "SELECT p.* FROM Playlist p NATURAL JOIN Avoir WHERE id_Utilisateur = :user";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':user', $userId, \PDO::PARAM_INT);
        $stmt->execute();
    
        $playlists = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
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

    public function insertPlaylist($nomP, $imgP, $userId) {
        try {
            if ($nomP !== "Favoris" && $nomP !== "favoris"){
                $this->connexion->beginTransaction();
        
                // Insérer la playlist dans la table Playlist
                $queryPlaylist = "INSERT INTO Playlist (nom_Playlist, img_Playlist) 
                                VALUES (:nom, :img)";
                $stmtPlaylist = $this->connexion->prepare($queryPlaylist);
                $stmtPlaylist->bindParam(':nom', $nomP);
                $stmtPlaylist->bindParam(':img', $imgP);
                $stmtPlaylist->execute();
        
                // Récupérer l'ID de la playlist nouvellement insérée
                $idPlaylist = $this->connexion->lastInsertId();
        
                // Insérer l'association dans la table Avoir
                $queryAvoir = "INSERT INTO Avoir (id_Playlist, id_Utilisateur) 
                            VALUES (:idPlaylist, :idUtilisateur)";
                $stmtAvoir = $this->connexion->prepare($queryAvoir);
                $stmtAvoir->bindParam(':idPlaylist', $idPlaylist);
                $stmtAvoir->bindParam(':idUtilisateur', $userId);
                $stmtAvoir->execute();
        
                $this->connexion->commit();
        
                return true;
            }else {
                // Si le nom de la playlist est "Favoris", retourner false car elle existe déja
                return "duplicate-favoris";
            }
        } catch (\PDOException $e) {
            $this->connexion->rollBack();
            // Vous pouvez logguer l'erreur au lieu de l'afficher directement
            error_log('Erreur insertion playlist : ' . $e->getMessage());
            return false;
        }
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

    public function deletePlaylist($idPlaylist) {
        try {
            $this->connexion->beginTransaction();

    
            // Supprimer les entrées correspondantes dans la table Renfermer
            $queryRenfermer = "DELETE FROM Renfermer WHERE id_Playlist = :idPlaylist";
            $stmtRenfermer = $this->connexion->prepare($queryRenfermer);
            $stmtRenfermer->bindParam(':idPlaylist', $idPlaylist, \PDO::PARAM_INT);
            $stmtRenfermer->execute();
    
            // Supprimer les entrées correspondantes dans la table Avoir
            $queryAvoir = "DELETE FROM Avoir WHERE id_Playlist = :idPlaylist";
            $stmtAvoir = $this->connexion->prepare($queryAvoir);
            $stmtAvoir->bindParam(':idPlaylist', $idPlaylist, \PDO::PARAM_INT);
            $stmtAvoir->execute();
    
            // Supprimer la playlist de la table Playlist
            $queryPlaylist = "DELETE FROM Playlist WHERE id_Playlist = :idPlaylist";
            $stmtPlaylist = $this->connexion->prepare($queryPlaylist);
            $stmtPlaylist->bindParam(':idPlaylist', $idPlaylist, \PDO::PARAM_INT);
            $stmtPlaylist->execute();
    
            $this->connexion->commit();
    
            return true;
        } catch (\PDOException $e) {
            $this->connexion->rollBack();
            // Vous pouvez logguer l'erreur au lieu de l'afficher directement
            error_log('Erreur suppression playlist : ' . $e->getMessage());
            return false;
        }
    }

    public function getSongByIdPlaylist($idPlaylist) {

    
        try {
            $query = "SELECT m.* FROM Musique m
                      NATURAL JOIN Renfermer r
                      WHERE r.id_Playlist = :idPlaylist";
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':idPlaylist', $idPlaylist, \PDO::PARAM_INT);
            $stmt->execute();

            $les_sons = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $musique = new Musique(
                    $row['id_Musique'],
                    $row['nom_Musique'],
                    $row['url_Musique']
                );
                $les_sons[] = $musique;
            }
    
            return $les_sons;
        } catch (\PDOException $e) {
            // Vous pouvez logguer l'erreur au lieu de l'afficher directement
            error_log('Erreur lors de la récupération des musiques par playlist : ' . $e->getMessage());
            return [];
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

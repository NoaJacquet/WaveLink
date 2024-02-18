<?php

declare(strict_types= 1);

namespace modele_bd;
use modele\Playlist;

class UtilisateurBD
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insertUser($pseudo, $mdp) {
        try {
            // Vérifie si le pseudo est déjà utilisé
            $pseudoCheck = $this->pdo->prepare('SELECT COUNT(*) FROM Utilisateur WHERE nom_Utilisateur = :pseudo');
            $pseudoCheck->execute(array('pseudo' => $pseudo));
            $pseudoExists = $pseudoCheck->fetchColumn() > 0;
    
            // Si le pseudo est déjà utilisé, retourne le type d'erreur approprié
            if ($pseudoExists) {
                return "duplicate_pseudo";
            }
    
            // Utilisation de prepared statements pour éviter les problèmes de sécurité
            $req = $this->pdo->prepare('INSERT INTO Utilisateur VALUES (NULL, :pseudo, :mdp, "default.png", "user")');
    
            // Exécution de la requête avec les valeurs associées
            $result = $req->execute(array(
                'pseudo' => $pseudo,
                'mdp' => $mdp
            ));
    
            // Vérification du succès de l'insertion
            if ($result) {
                $id_utilisateur = $this->pdo->lastInsertId();

                // Créer une playlist "favoris" pour le nouvel utilisateur
                $reqPlaylist = $this->pdo->prepare('INSERT INTO Playlist (nom_Playlist, img_Playlist) VALUES (:nom, :img)');
                $resultPlaylist = $reqPlaylist->execute(array(
                    'nom' => 'Favoris',
                    'img' => 'favoris.png'
                ));

                if ($resultPlaylist) {
                    // Récupérer l'ID de la playlist "favoris" créée
                    $id_playlist = $this->pdo->lastInsertId();

                    // Associer la playlist "favoris" à l'utilisateur dans la table Avoir
                    $reqAvoir = $this->pdo->prepare('INSERT INTO Avoir (id_Playlist, id_Utilisateur) VALUES (:id_playlist, :id_utilisateur)');
                    $reqAvoir->execute(array(
                        'id_playlist' => $id_playlist,
                        'id_utilisateur' => $id_utilisateur
                    ));
                    return $id_utilisateur;
                }
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            // Vous pouvez logguer l'erreur au lieu de l'afficher directement
            error_log('Erreur inscription : ' . $e->getMessage());
            return false;
        }
    }
    

    public function checkLogin($pseudo, $password)
    {
        try {
            $req = $this->pdo->prepare('SELECT * FROM Utilisateur WHERE nom_Utilisateur = :pseudo AND mdp_Utilisateur = :password');
            $req->execute(array(
                'pseudo' => $pseudo,
                'password' => $password,
            ));

            $user = $req->fetch();

            if ($user) {
                return array('role' => $user['role'], 'id' => $user['id_Utilisateur']);
            } else {
                // Retourner false en cas d'échec de la connexion
                return false;
            }
        } catch (\PDOException $e) {
            echo 'Erreur login : ' . $e->getMessage();
            return false;
        }
    }

    public function getAllPlaylistByUser($id){
        $les_playlists = array();
        try{
            $req = $this->pdo->prepare('SELECT id_Playlist, nom_Playlist, img_Playlist FROM Playlist natural join Avoir WHERE id_Utilisateur = :id');
            $req->execute(array('id'=>$id));
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($result as $playlist){
                array_push($les_playlists, new Playlist($playlist['id_Playlist'], $playlist['nom_Playlist'], $playlist['img_Playlist']));
            }
            return $les_playlists;
        }catch (\PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
    }

}
?>
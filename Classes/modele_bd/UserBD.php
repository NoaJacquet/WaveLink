<?php

declare(strict_types= 1);

namespace modele_bd;
class UserBD
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
    
            // Si le pseudo ou l'email est déjà utilisé, retourne le type d'erreur approprié
            if ($pseudoExists) {
                return "duplicate_pseudo";
            }
    
            $req = $this->pdo->prepare('INSERT INTO Utilisateur VALUES (NULL, :pseudo, :mdp, "default.png")');
    
            // Exécution de la requête avec les valeurs associées
            $result = $req->execute(array(
                'pseudo' => $pseudo,
                'mdp' => $mdp
            ));
    
            // Vérification du succès de l'insertion
            return $result;
        } catch (\PDOException $e) {
            echo 'Erreur inscription : ' . $e->getMessage();
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

            return $req->fetch();
        } catch (\PDOException $e) {
            echo 'Erreur login : ' . $e->getMessage();
            return false;
        }
    }
}



?>
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

    public function insertUser($pseudo, $email, $mdp) {
        try {
            // Vérifie si le pseudo est déjà utilisé
            $pseudoCheck = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE pseudo = :pseudo');
            $pseudoCheck->execute(array('pseudo' => $pseudo));
            $pseudoExists = $pseudoCheck->fetchColumn() > 0;
    
            // Vérifie si l'email est déjà utilisé
            $emailCheck = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
            $emailCheck->execute(array('email' => $email));
            $emailExists = $emailCheck->fetchColumn() > 0;
    
            // Si le pseudo ou l'email est déjà utilisé, retourne le type d'erreur approprié
            if ($pseudoExists) {
                return "duplicate_pseudo";
            } elseif ($emailExists) {
                return "duplicate_email";
            }
    
            // Si tout est OK, effectue l'insertion
            // Préparation de la requête d'insertion
            $req = $this->pdo->prepare('INSERT INTO users VALUES (NULL, :pseudo, :mdp, :email)');
    
            // Exécution de la requête avec les valeurs associées
            $result = $req->execute(array(
                'pseudo' => $pseudo,
                'mdp' => $mdp,
                'email' => $email
            ));
    
            // Vérification du succès de l'insertion
            return $result;
        } catch (\PDOException $e) {
            echo 'Erreur inscription : ' . $e->getMessage();
            return false;
        }
    }
    
    
    


    public function checkLogin($email, $password)
    {
        try {
            $req = $this->pdo->prepare('SELECT * FROM users WHERE email = :email AND mdp = :password');
            $req->execute(array(
                'email' => $email,
                'password' => $password,
            ));

            return $req->fetch();
        } catch (\PDOException $e) {
            echo 'Erreur login : ' . $e->getMessage();
            return false;
        }
    }
}

// // Utilisation de la classe UserBD
// $databaseManager = new DatabaseManager();
// $userBD = new UserBD($databaseManager->getPDO());

// if ($_SERVER['REQUEST_METHOD'] == "POST") {
//     $email = $_POST["email"];
//     $password = $_POST["password"];

//     if ($email != "" && $password != "") {
//         $user = $userBD->checkLogin($email, $password);

//         if ($user) {
//             echo "Vous êtes connecté";
//         } else {
//             $error_msg = "Email ou mot de passe incorrect";
//         }
//     }
// }



?>
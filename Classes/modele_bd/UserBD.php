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

    public function insertUser($pseudo, $email, $mdp)
    {
        try {
            // Préparation de la requête d'insertion
            $req = $this->pdo->prepare('INSERT INTO users VALUES (NULL, :pseudo, :mdp, :email)');

            // Exécution de la requête avec les valeurs associées
            $req->execute(array(
                'pseudo' => $pseudo,
                'mdp' => $mdp,
                'email' => $email
            ));

            // Vérification du succès de l'insertion
            return $req->rowCount() > 0;
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
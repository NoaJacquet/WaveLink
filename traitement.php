<?php

try {
    // Connexion en utilisant la connexion PDO avec le moteur en préfixe
    $pdo = new PDO('sqlite:db.sqlite');
    // Permet de gérer le niveau des erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur : '. $e->getMessage();
}

if (isset($_POST["ok"])) {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    // Préparation de la requête d'insertion
    $req = $pdo->prepare('INSERT INTO users VALUES (NULL, :pseudo, :mdp, :email)');

    // Exécution de la requête avec les valeurs associées
    $req->execute(array(
        'pseudo' => $pseudo,
        'mdp' => $mdp,
        'email' => $email
    ));

    $reponse = $req->fetchAll(PDO::FETCH_ASSOC);
    var_dump($reponse);

    // Vérification du succès de l'insertion
    if ($req) {
        echo "Inscription réussie !";
    } else {
        echo "Erreur lors de l'inscription.";
    }
}

// Fermeture de la connexion à la base de données
$pdo = null;
?>

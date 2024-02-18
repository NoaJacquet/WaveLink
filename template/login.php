<?php



use modele_bd\Connexion;
use modele_bd\UtilisateurBD;

$connexion = new Connexion();
$connexion->connexionBD();

$userManager = new UtilisateurBD($connexion->getPDO());

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $pseudo = $_POST["pseudo"];
    $password = $_POST["password"];

    if ($pseudo != "" && $password != "") {
        $loginResult = $userManager->checkLogin($pseudo, $password);

        if ($loginResult !== false) {
            $role = $loginResult['role'];
            $id = $loginResult['id'];

            if ($role === 'admin') {
                header("Location: /accueil_admin");
                exit();
            } elseif ($role === 'user') {
                header("Location: /accueil_user?id=".$id);
                exit();
            }
        } else {
            $error_msg = "pseudo ou mot de passe incorrect";
            echo "<script>alert('$error_msg');</script>";
        }
    }
}


?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/login.css"> 
    <title>login</title>
</head>
<body>
    <main>

        <section id='logo'>
            <h1>LOGIN HERE</h1>
            <img src="images/logo.png" alt="Logo">
        </section>

        <section id="log">
            <form method="POST" action="">
                <label for="pseudo">Nom d'utilisateur</label>
                <input type="pseudo" placeholder="Entrer votre pseudo" id="pseudo" name="pseudo" required>

                <label for="password">Mot de passe</label>
                <input type="password" placeholder="Entrer votre Mot de passe" id="password" name="password" required>
                <button>
                    <span class="box">
                        Connexion
                    </span>
                </button>
                

                <p>Vous n’avez pas de compte ? <a href="/inscription">Inscrivez-vous!</a></p>

            </form>
        </section>
    </main>
    
</body>
</html>
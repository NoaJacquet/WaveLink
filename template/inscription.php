<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/login.css"> 
    <title>Inscription</title>
</head>
<body>
        <?php

        use modele_bd\UtilisateurBD;
        use modele_bd\Connexion;

        $connexion = new Connexion();
        $connexion->connexionBD();

        $userManager = new UtilisateurBD($connexion->getPDO());

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $pseudo = $_POST["pseudo"];
            $mdp = $_POST["mdp"];

            if ($pseudo != "" && $mdp != "") {
                $success = $userManager->insertUser($pseudo, $mdp);

                if ($success === true) {
                    header("Location: /accueil");
                    exit();
                } else {
                    $error_msg = "Erreur lors de l'inscription. Veuillez réessayer.";

                    if ($success === "duplicate_pseudo") {
                        $error_msg = "Le pseudo est déjà pris. Veuillez en choisir un autre.";
                    }

                    $registrationFailed = true;
                }
            }
        }
        ?>




    <main>

        <section id='logo'>
            <h1>REGISTER HERE</h1>
            <img src="images/logo.png" alt="Logo">
        </section>
        <section id="log">
            <form method="POST" action="">
                <label for="pseudo">Pseudo :</label>
                <input type="text" id="pseudo" name="pseudo" placeholder="Entrez votre pseudo" required><br>

                <label for="mdp">Mot de passe :</label>
                <input type="password" id="mdp" name="mdp" placeholder="Entrez votre mot de passe" required><br>
               
                <button>
                    <span class="box">
                        Hover!
                    </span>
                </button>
                

                <p>Vous avez déjà compte ? <a href="/login">Connectez-vous!</a></p>

            </form>
        </section>
        
    </main>
    


</body>
</html>

    <?php
    if ($registrationFailed) {
        echo "<script>alert(\"$error_msg\");</script>";
    }
    ?>
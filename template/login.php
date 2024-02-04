<!-- login.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/login.css"> 
    <title>login</title>
</head>
<body>

    <?php
        use modele_bd\Connexion;
        use modele_bd\UserBD;

        $connexion = new Connexion();
        $connexion->connexionBD();

        $userManager = new UserBD($connexion->getPDO());

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];

            if ($email != "" && $password != "") {
                $user = $userManager->checkLogin($email, $password);

                if ($user) {
                    header("Location: /accueil");
                    exit();
                } else {
                    $error_msg = "Email ou mot de passe incorrect";
                }
            }
        }
    ?>
    <main>

        <section id='logo'>
            <h1>LOGIN HERE</h1>
            <img src="images/logo.png" alt="Logo">
        </section>

        <section id="log">
            <form method="POST" action="">
                <label for="email">Email</label>
                <input type="email" placeholder="Entrer votre Email" id="email" name="email" required>

                <label for="password">Mot de passe</label>
                <input type="password" placeholder="Entrer votre Mot de passe" id="password" name="password" required>
                <button>
                    <span class="box">
                        Hover!
                    </span>
                </button>
                

                <p>Vous n’avez pas de compte ? <a href="/inscription">Inscrivez-vous!</a></p>

            </form>
        </section>
    </main>


    <?php
        if ($error_msg){
            echo $error_msg;
        } 
    ?>
    
</body>
</html>
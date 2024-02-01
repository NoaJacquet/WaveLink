<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/login.css"> 
    <title>Inscription</title>
</head>
<body>
    <main>

        <section id='logo'>
            <h1>LOGIN HERE</h1>
            <img src="images/logo.png" alt="Logo">
        </section>

        <section id="log">
            <form method="POST" action="../traitement.php">
                <label for="pseudo">Pseudo :</label>
                <input type="text" id="pseudo" name="pseudo" placeholder="Entrez votre pseudo" required><br>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" placeholder="Entrez votre adresse email" required><br>

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

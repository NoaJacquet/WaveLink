<?php

// InterpreterBD.php

// modele_bd/InterpreterBD.php
require_once 'Chemin/vers/la/classe/Interpreter.php';

class InterpreterBD {
    private $connexion; // Vous devrez fournir une instance de connexion à la base de données ici

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllInterpreters() {
        $query = "SELECT * FROM Interpreter";
        $result = $this->connexion->query($query);

        $interpreters = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $interpreter = new Interpreter(
                $row['id_Musique'],
                $row['id_Artistes']
            );
            $interpreters[] = $interpreter;
        }

        return $interpreters;
    }

    public function insertInterpreter(Interpreter $interpreter) {
        $query = "INSERT INTO Interpreter (id_Musique, id_Artistes) 
                  VALUES (:idMusique, :idArtistes)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idMusique', $interpreter->getIdMusique(), PDO::PARAM_INT);
        $stmt->bindParam(':idArtistes', $interpreter->getIdArtistes(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteInterpreter($idMusique, $idArtistes) {
        $query = "DELETE FROM Interpreter WHERE id_Musique = :idMusique AND id_Artistes = :idArtistes";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':idMusique', $idMusique, PDO::PARAM_INT);
        $stmt->bindParam(':idArtistes', $idArtistes, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Ajoutez d'autres méthodes selon vos besoins
}

<?php

namespace modele_bd;
class Connexion
{
    private $pdo;

    public function connexionBD()
    {
        try {
            // Le chemin d'accès relatif doit être ajusté pour remonter de deux répertoires vers "Data"
            $dbPath = realpath(__DIR__ . '/../../Data/db.sqlite');
            
            // Connexion en utilisant la connexion PDO avec le moteur en préfixe
            $this->pdo = new \PDO('sqlite:' . $dbPath);
            
            // Permet de gérer le niveau des erreurs
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo 'Erreur --MMMhh---: ' . $e->getMessage();
        }
    }

    public function getPDO()
    {
        // Retourne l'objet PDO
        return $this->pdo;
    }

    // Ajoutez d'autres méthodes de votre classe au besoin
}

<?php

// Utilisateur.php

namespace modele;

class Utilisateur {
    public $id_Utilisateur;
    public $nom_Utilisateur;
    public $mdp_Utilisateur;
    public $img_Utilisateur;

    public function __construct($id_Utilisateur, $nom_Utilisateur, $mdp_Utilisateur, $img_Utilisateur) {
        $this->id_Utilisateur = $id_Utilisateur;
        $this->nom_Utilisateur = $nom_Utilisateur;
        $this->mdp_Utilisateur = $mdp_Utilisateur;
        $this->img_Utilisateur = $img_Utilisateur;
    }

    // Getters
    public function getIdUtilisateur() {
        return $this->id_Utilisateur;
    }

    public function getNomUtilisateur() {
        return $this->nom_Utilisateur;
    }

    public function getMdpUtilisateur() {
        return $this->mdp_Utilisateur;
    }

    public function getImgUtilisateur() {
        return $this->img_Utilisateur;
    }
}

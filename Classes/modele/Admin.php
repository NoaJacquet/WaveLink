<?php

// Admin.php

class Admin {
    public $id_Adm;
    public $nom_Adm;
    public $mdp_Adm;

    public function __construct($id_Adm, $nom_Adm, $mdp_Adm) {
        $this->id_Adm = $id_Adm;
        $this->nom_Adm = $nom_Adm;
        $this->mdp_Adm = $mdp_Adm;
    }

    // Getters
    public function getIdAdmin() {
        return $this->id_Adm;
    }

    public function getNomAdmin() {
        return $this->nom_Adm;
    }

    public function getMdpAdmin() {
        return $this->mdp_Adm;
    }
}

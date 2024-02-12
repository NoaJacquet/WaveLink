<?php

// Musique.php
namespace modele;

class Musique {
    public $id_Musique;
    public $nom_Musique;


    public function __construct($id_Musique, $nom_Musique) {
        $this->id_Musique = $id_Musique;
        $this->nom_Musique = $nom_Musique;

    }

    // Getters
    public function getIdMusique() {
        return $this->id_Musique;
    }

    public function getNomMusique() {
        return $this->nom_Musique;
    }

}

<?php

// Noter.php

class Noter {
    public $id_Utilisateur;
    public $id_Album;
    public $note;

    public function __construct($id_Utilisateur, $id_Album, $note) {
        $this->id_Utilisateur = $id_Utilisateur;
        $this->id_Album = $id_Album;
        $this->note = $note;
    }

    // Getters
    public function getIdUtilisateur() {
        return $this->id_Utilisateur;
    }

    public function getIdAlbum() {
        return $this->id_Album;
    }

    public function getNote() {
        return $this->note;
    }
}

<?php 
// Avoir.php

class Avoir {
    public $id_Playlist;
    public $id_Utilisateur;

    public function __construct($id_Playlist, $id_Utilisateur) {
        $this->id_Playlist = $id_Playlist;
        $this->id_Utilisateur = $id_Utilisateur;
    }

    // Getters
    public function getIdPlaylist() {
        return $this->id_Playlist;
    }

    public function getIdUtilisateur() {
        return $this->id_Utilisateur;
    }
}

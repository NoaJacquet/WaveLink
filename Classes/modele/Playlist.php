<?php

// Playlist.php
namespace modele;
class Playlist {
    public $id_Playlist;
    public $nom_Playlist;

    public $img_Playlist;

    public function __construct($id_Playlist, $nom_Playlist, $img_Playlist) {
        $this->id_Playlist = $id_Playlist;
        $this->nom_Playlist = $nom_Playlist;
        $this->img_Playlist = $img_Playlist;
    }

    // Getters
    public function getIdPlaylist() {
        return $this->id_Playlist;
    }

    public function getNomPlaylist() {
        return $this->nom_Playlist;
    }

    public function getImgPlaylist() {
        return $this->img_Playlist;
    }
}

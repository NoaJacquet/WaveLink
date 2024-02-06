<?php

// Renfermer.php

class Renfermer {
    public $id_Playlist;
    public $id_Musique;

    public function __construct($id_Playlist, $id_Musique) {
        $this->id_Playlist = $id_Playlist;
        $this->id_Musique = $id_Musique;
    }

    // Getters
    public function getIdPlaylist() {
        return $this->id_Playlist;
    }

    public function getIdMusique() {
        return $this->id_Musique;
    }
}

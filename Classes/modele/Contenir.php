<?php

// Contenir.php

class Contenir {
    public $id_Album;
    public $id_Musique;

    public function __construct($id_Album, $id_Musique) {
        $this->id_Album = $id_Album;
        $this->id_Musique = $id_Musique;
    }

    // Getters
    public function getIdAlbum() {
        return $this->id_Album;
    }

    public function getIdMusique() {
        return $this->id_Musique;
    }
}

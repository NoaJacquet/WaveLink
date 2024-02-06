<?php

// Appartenir.php

class Appartenir {
    public $id_Genre;
    public $id_Album;

    public function __construct($id_Genre, $id_Album) {
        $this->id_Genre = $id_Genre;
        $this->id_Album = $id_Album;
    }

    // Getters
    public function getIdGenre() {
        return $this->id_Genre;
    }

    public function getIdAlbum() {
        return $this->id_Album;
    }
}
?>
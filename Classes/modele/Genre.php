<?php

// Genre.php

namespace modele;

class Genre {
    public $id_Genre;
    public $nom_Genre;

    public $img_Genre;

    public function __construct($id_Genre, $nom_Genre, $img_Genre) {
        $this->id_Genre = $id_Genre;
        $this->nom_Genre = $nom_Genre;
        $this->img_Genre = $img_Genre;
    }

    // Getters
    public function getIdGenre() {
        return $this->id_Genre;
    }

    public function getNomGenre() {
        return $this->nom_Genre;
    }

    public function getImgGenre() {
        return $this->img_Genre;
    }

}


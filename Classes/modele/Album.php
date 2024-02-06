<?php

// Album.php

namespace modele;

class Album {
    public $id_Album;
    public $titre_Album;
    public $genre_Album;
    public $annee_Sortie;
    public $img_Album;

    public function __construct($id_Album, $titre_Album, $genre_Album, $annee_Sortie, $img_Album) {
        $this->id_Album = $id_Album;
        $this->titre_Album = $titre_Album;
        $this->genre_Album = $genre_Album;
        $this->annee_Sortie = $annee_Sortie;
        $this->img_Album = $img_Album;
    }

    // Getters
    public function getIdAlbum() {
        return $this->id_Album;
    }

    public function getTitreAlbum() {
        return $this->titre_Album;
    }

    public function getGenreAlbum() {
        return $this->genre_Album;
    }

    public function getAnneeSortie() {
        return $this->annee_Sortie;
    }

    public function getImgAlbum() {
        return $this->img_Album;
    }
}

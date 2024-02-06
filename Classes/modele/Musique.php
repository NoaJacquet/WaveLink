<?php

// Musique.php

class Musique {
    public $id_Musique;
    public $nom_Musique;
    public $genre_Musique;
    public $interprete_Musique;
    public $Compositeur_Musique;
    public $annee_Sortie_Musique;

    public function __construct($id_Musique, $nom_Musique, $genre_Musique, $interprete_Musique, $Compositeur_Musique, $annee_Sortie_Musique) {
        $this->id_Musique = $id_Musique;
        $this->nom_Musique = $nom_Musique;
        $this->genre_Musique = $genre_Musique;
        $this->interprete_Musique = $interprete_Musique;
        $this->Compositeur_Musique = $Compositeur_Musique;
        $this->annee_Sortie_Musique = $annee_Sortie_Musique;
    }

    // Getters
    public function getIdMusique() {
        return $this->id_Musique;
    }

    public function getNomMusique() {
        return $this->nom_Musique;
    }

    public function getGenreMusique() {
        return $this->genre_Musique;
    }

    public function getInterpreteMusique() {
        return $this->interprete_Musique;
    }

    public function getCompositeurMusique() {
        return $this->Compositeur_Musique;
    }

    public function getAnneeSortieMusique() {
        return $this->annee_Sortie_Musique;
    }
}

<?php

// Artistes.php

namespace modele;

class Artistes {
    public $id_Artistes;
    public $nom_Artistes;
    public $img_Artistes;

    public function __construct($id_Artistes, $nom_Artistes, $img_Artistes) {
        $this->id_Artistes = $id_Artistes;
        $this->nom_Artistes = $nom_Artistes;
        $this->img_Artistes = $img_Artistes;
    }

    // Getters
    public function getIdArtistes() {
        return $this->id_Artistes;
    }

    public function getNomArtistes() {
        return $this->nom_Artistes;
    }

    public function getImgArtistes() {
        return $this->img_Artistes;
    }
}

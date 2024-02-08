<?php

// Creer.php

namespace modele;

class Creer {
    public $id_Artistes;
    public $id_Album;

    public function __construct($id_Artistes, $id_Album) {
        $this->id_Artistes = $id_Artistes;
        $this->id_Album = $id_Album;
    }

    // Getters
    public function getIdArtistes() {
        return $this->id_Artistes;
    }

    public function getIdAlbum() {
        return $this->id_Album;
    }
}

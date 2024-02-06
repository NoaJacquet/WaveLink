<?php

// Interpreter.php

class Interpreter {
    public $id_Musique;
    public $id_Artistes;

    public function __construct($id_Musique, $id_Artistes) {
        $this->id_Musique = $id_Musique;
        $this->id_Artistes = $id_Artistes;
    }

    // Getters
    public function getIdMusique() {
        return $this->id_Musique;
    }

    public function getIdArtistes() {
        return $this->id_Artistes;
    }
}

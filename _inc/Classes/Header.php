<?php

declare(strict_types=1);

namespace Classes;
use Classes\RenderInterface;

Class Header implements RenderInterface{

    public function render(){
        $res = '<header>';
        $res .= '<ul id="header">';
        $res .= '<li><h1>Wavelink</h1></li>';
        $res .= '<li><input type=text placeholder="Rechercher"></li>';
        $res .= '<li><p>image</p></li>';
        $res .= '</ul>';
        $res .= '</header>';
        return $res;
    }

}
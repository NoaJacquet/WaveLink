<?php

declare(strict_types=1);

namespace View;
use View\RenderInterface;

Class Header implements RenderInterface{

    public function render(){
        $res = '<header>';
        $res .= '<ul>';
        $res .= '<li><img src="../../images/logo.png" alt="logo"></li>';
        $res .= '<li><h1>Wavelink</h1></li>';
        $res .= '<li><input type=text placeholder="Rechercher"></li>';
        $res .= '<li><p>image</p></li>';
        $res .= '</ul>';
        $res .= '</header>';
        return $res;
    }

}
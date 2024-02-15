<?php

declare(strict_types=1);

namespace View;
use View\RenderInterface;

Class Header implements RenderInterface{

    public function render(){
        $res = '<header>';
        $res .= '<ul>';
        $res .= '<a href="/accueil"><li><img src="../../images/logo.png" alt="logo"></li></a>';
        $res .= '<li><h1>Wavelink</h1></li>';
        $res .= '<li><input type=text placeholder="Rechercher"></li>';
        $res .= '</ul>';
        $res .= '</header>';
        return $res;
    }

}
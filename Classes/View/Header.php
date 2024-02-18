<?php

declare(strict_types=1);

namespace View;

Class Header{

    public function renderH($userId){
        $res = '<header>';
        $res .= '<ul>';
        $res .= '<a href="/accueil_user?id='.$userId.'"><li><img src="../../images/logo.png" alt="logo"></li></a>';
        $res .= '<li><h1>Wavelink</h1></li>';
        $res .= '<li><input type=text placeholder="Rechercher"></li>';
        $res .= '</ul>';
        $res .= '</header>';
        return $res;
    }

    public function renderBis(){
        $res = '<header>';
        $res .= '<ul>';
        $res .= '<a href="/accueil_admin"><li><img src="../../images/logo.png" alt="logo"></li></a>';
        $res .= '<li><h1>Wavelink</h1></li>';
        $res .= '<li><input type=text placeholder="Rechercher"></li>';
        $res .= '<li><p>image</p></li>';
        $res .= '</ul>';
        $res .= '</header>';
        return $res;
    }

}
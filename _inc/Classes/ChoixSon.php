<?php

declare(strict_types=1);

namespace Classes;
use Classes\RenderInterface;

Class ChoixSon implements RenderInterface{

    public function render(){
        $res = '<div id="playlist-choisi">';
        $res .= '    <h1>Rap</h1>';
        $res .= '    <a href="">';
        $res .= '        <div id="son">';
        $res .= '            <img src="chambre140.jpg" alt="">';
        $res .= '            <div>';
        $res .= '                <p>Mignon tout plein</p>';
        $res .= '                <p>PLK</p>';
        $res .= '            </div>';
        $res .= '        </div>';
        $res .= '    </a>';
        $res .= '</div>';
        return $res;
    }

}
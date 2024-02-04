<?php

declare(strict_types=1);

namespace Classes;
use Classes\RenderInterface;

Class Playlist implements RenderInterface{

    public function render(){
        $res = "<div id='playlist'>";
        $res .= "<h2>Playlist</h2>";
        $res .= "    <ul>";
        $res .= "        <li>";
        $res .= "            <div id='barre'></div>";
        $res .= "            <a href=''>";
        $res .= "                <div id='detail-playlist'>";
        $res .= "                    <img src='rap.jpg' alt=''>";
        $res .= "                    <p>Rap</p>";
        $res .= "                </div>";
        $res .= "            </a>";
        $res .= "        </li>";
        $res .= "        <li>";
        $res .= "            <div id='barre'></div>";
        $res .= "            <a href=''>";
        $res .= "                <div id='detail-playlist'>";
        $res .= "                    <img src='rap.jpg' alt=''>";
        $res .= "                    <p>Rap</p>";
        $res .= "                </div>";
        $res .= "            </a>";
        $res .= "        </li>";
        $res .= "    </ul>";
        $res .= "</div>";
        return $res;
    }

}
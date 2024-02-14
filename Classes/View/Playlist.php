<?php

declare(strict_types=1);

namespace View;
use View\RenderInterface;
use modele_bd\Connexion;
use modele_bd\UserBD;

Class Playlist implements RenderInterface{

    public function render(){

        $connexion = new Connexion();
        $connexion->connexionBD();

        $userManager = new UserBD($connexion->getPDO());

        $playlists = $userManager->getAllPlaylistByUser(1);
        $res = "<div id='playlist'>";
        $res .="<h2>Playlist</h2>";
        $res .="<ul>";
        $res .= "<li>";
        $res .= "<p>+</p>";
        $res .= "</li>";
        foreach($playlists as $key => $playlist){
            $res .= "<li>";
            $res .= "<div id='barre'></div>";
            $res .= "<a href='/detail-playlist'>";
            $res .= "<div id='detail-playlist'>";
            $res .= "<img src='rap.jpg' alt=''>";
            $res .= "<p>".$playlist->getNomPlaylist()."</p>";
            $res .= "<p>test</p>";
            $res .= "</div>";
            $res .= "</a>";
            $res .= "</li>";
        }
        $res .="</ul>";
        $res .="</div>";
        return $res;
    }

}
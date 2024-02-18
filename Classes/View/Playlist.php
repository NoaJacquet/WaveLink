<?php

declare(strict_types=1);

namespace View;
use modele_bd\PlaylistBD;
use modele_bd\Connexion;
use modele_bd\UtilisateurBD;

Class Playlist{

    public function renderPlaylist($userId){

        $connexion = new Connexion();
        $connexion->connexionBD();

        $userManager = new UtilisateurBD($connexion->getPDO());
        $playlistBD = new PlaylistBD($connexion->getPDO());

        $playlists = $userManager->getAllPlaylistByUser($userId);

        $favoris = $playlistBD->getFavorisById($userId);


        echo "<div id='playlist'>";
        echo "<div id='detail-playlist'>";
        echo '<a href="/detail-playlist?id=' . $favoris->getIdPlaylist() . '">';
        echo "<img src='../../images/".$favoris->getImgPlaylist()."' alt='".$favoris->getNomPlaylist()."'>";
        echo "<p>".$favoris->getNomPlaylist()."</p>";
        echo "</a>";
        echo "</div>";
        echo "<div id='creer-playlist'> <h2>Playlist</h2> <a href='/add-playlist?id=".$userId."'>+$userId </a> </div>";
        echo"<ul>";
        foreach($playlists as $playlist){
            if($playlist->getNomPlaylist()!='Favoris'){
                echo "<li>";
                echo "<div id='barre'></div>";
                echo "<div id='detail-playlist'>";
                echo '<a href="/detail-playlist?id=' . $playlist->getIdPlaylist() . '">';
                echo "<img src='../../images/".$playlist->getImgPlaylist()."' alt='".$playlist->getNomPlaylist()."'>";
                echo "<p>".$playlist->getNomPlaylist()."</p>";
                echo "</a>";
                echo "</div>";
                echo "</li>";
            }

            

        }
        echo"</ul>";
        echo"</div>";

    }

}
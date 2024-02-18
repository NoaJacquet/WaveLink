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
        echo '<a href="/detail-playlist?id=' . $favoris->getIdPlaylist() . '&userId=' . $userId . '">';
        echo "<img src='../../images/".$favoris->getImgPlaylist()."' alt='".$favoris->getNomPlaylist()."'>";
        echo "<p>".$favoris->getNomPlaylist()."</p>";
        echo "</a>";
        echo "</div>";
        echo "<div id='creer-playlist'> <h2>Playlist</h2> <a href='/add-playlist?id=".$userId."'>+</a> </div>";
        foreach($playlists as $playlist){
            if($playlist->getNomPlaylist()!='Favoris'){
                echo "<div id='detail-playlist'>";
                echo '<a href="/detail-playlist?id=' . $playlist->getIdPlaylist(). '&userId='. $userId . '">';
                echo "<img src='../../images/".$playlist->getImgPlaylist()."' alt='".$playlist->getNomPlaylist()."'>";
                echo "<p>".$playlist->getNomPlaylist()."</p>";
                echo "</a>";
                echo "</div>";
            }

            

        }
        echo"</ul>";
        echo"</div>";

    }

}
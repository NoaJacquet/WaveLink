<?php
namespace View;
use modele\Musique;

class MusiqueView
{
    public static function renderMusiques($musiques, $count = 6)
    {
        foreach ($musiques as $musique) {
            echo '<div class="card">';
            echo '<p class="titre">' . $musique->getNomMusique().'</p>';
            echo '</div>';

            $count--;

            // Stop after displaying the specified number of musiques
            if ($count <= 0) {
                break;
            }
        }
    }

    public static function renderAllMusiques($musiques){
        if (empty($musiques)) {
            echo '<p>Aucune musique</p>';
        } else {
            foreach ($musiques as $musique) {
                echo '<div class="card">';
                echo '<p class="titre">' . $musique->getNomMusique().'</p>';
                echo '</div>';
            }
        }
    }

}
?>

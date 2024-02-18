<?php
namespace View;


class ArtisteView
{
    public static function renderArtistes($artistes, $count)
    {
        
        foreach ($artistes as $artiste) {

            echo '<div class="card">';
            echo '<a href="/artiste_detail?id=' . $artiste->getIdArtistes() . '">';
            echo '<img src="images/' . rawurlencode($artiste->getImgArtistes()) . '" alt="' . $artiste->getNomArtistes(). '">';
            echo '<p class="nom">' . $artiste->getNomArtistes() . '</p>';
            echo '</a>';
            echo '</div>';

            $count--;

            // Arrêter après avoir affiché les artistes spécifiés
            if ($count <= 0) {
                break;
            }
        }

    }

    public static function renderArtistesBis($artistes, $count, $userId)
    {

        if (empty($artistes)) {
            echo '<p>Aucun artiste trouvé.</p>';
            return;
        }
        
        foreach ($artistes as $artiste) {

            echo '<div class="card">';
            echo '<a href="/artiste?id=' . $artiste->getIdArtistes() . '&userId='. $userId.'">';
            echo '<img src="images/' . rawurlencode($artiste->getImgArtistes()) . '" alt="' . $artiste->getNomArtistes(). '">';
            echo '<p class="nom">' . $artiste->getNomArtistes() . '</p>';
            echo '</a>';
            echo '</div>';

            $count--;

            // Arrêter après avoir affiché les artistes spécifiés
            if ($count <= 0) {
                break;
            }
        }

    }

    
}
?>

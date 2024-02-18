<?php
namespace View;
use modele_bd\GenreBD;

class GenreView
{
    public static function renderGenres($genres, $count)
    {
        foreach ($genres as $genre) {
            // Utilisez les méthodes appropriées de la classe $genreBD
            // pour obtenir les détails supplémentaires du genre si nécessaire.
            echo '<div class="card">';
            echo '<a href="/genre_detail?id=' . $genre->getIdGenre() . '">';
            echo '<img src="images/' . rawurlencode($genre->getImgGenre()) . '" alt="' . $genre->getNomGenre(). '">';

            echo '<p class="nom">' . $genre->getNomGenre() . '</p>';
            // Ajoutez d'autres informations du genre si nécessaire.
            echo '</a>';
            echo '</div>';

            $count--;

            // Arrêter après avoir affiché les genres spécifiés
            if ($count <= 0) {
                break;
            }
        }
    }

    public static function renderGenresBis($genres, $count, $userId){
        if (empty($genres)) {
            echo '<p>Aucun genre trouvé.</p>';
            return;
        }

        foreach ($genres as $genre) {
            // Utilisez les méthodes appropriées de la classe $genreBD
            // pour obtenir les détails supplémentaires du genre si nécessaire.
            echo '<div class="card">';
            echo '<a href="/genre?id=' . $genre->getIdGenre() . '&userId='. $userId. '">';
            echo '<img src="images/' . rawurlencode($genre->getImgGenre()) . '" alt="' . $genre->getNomGenre(). '">';
            echo '<p class="nom">' . $genre->getNomGenre() . '</p>';
            // Ajoutez d'autres informations du genre si nécessaire.
            echo '</a>';
            echo '</div>';

            $count--;

            // Arrêter après avoir affiché les genres spécifiés
            if ($count <= 0) {
                break;
            }
        }
    }
}
?>

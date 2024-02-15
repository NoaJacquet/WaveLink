<?php
namespace View;
use modele_bd\ArtistesBD;
use modele_bd\AlbumBD;


class AlbumView
{
    public static function renderAlbums($albums, ArtistesBD $artisteBD, AlbumBD $albumBD, $count = 6)
    {
        foreach ($albums as $album) {
            $artiste = $artisteBD->getArtistByAlbumId($album->getIdAlbum());
            echo '<div class="card">';
            echo '<a href="/album_detail_admin?id=' . $album->getIdAlbum() . '">';
            echo '<img src="images/' . rawurlencode($album->getImgAlbum()) . '" alt="' . $album->getTitreAlbum(). '">';
            echo '<p class="titre">' . $album->getTitreAlbum().'</p>';
            echo '<p class="">' . $artiste->getNomArtistes().'</p>';
            echo '</a>';
            echo '</div>';

            $count--;

            // Arrêter après avoir affiché les albums spécifiés
            if ($count <= 0) {
                break;
            }
        }
    }

    public static function renderAllAlbums($albums, ArtistesBD $artisteBD)
    {
        
        foreach ($albums as $album) {
            $artiste = $artisteBD->getArtistByAlbumId($album->getIdAlbum());
            echo '<div class="card">';
            echo '<a href="/album_detail_admin?id=' . $album->getIdAlbum() . '">';
            echo '<img src="images/' . rawurlencode($album->getImgAlbum()) . '" alt="' . $album->getTitreAlbum(). '">';
            echo '<p class="titre">' . $album->getTitreAlbum().'</p>';
            echo '<p class="">' . $artiste->getNomArtistes().'</p>';
            echo '</a>';
            echo '</div>';
        }
    }
}
?>

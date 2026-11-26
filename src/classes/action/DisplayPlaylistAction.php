<?php

namespace iutnc\deefy\action;

use iutnc\deefy\render\AudioListRenderer;

class DisplayPlaylistAction extends Action
{
    public function execute(): string
    {
        if (!isset($_SESSION['playlist'])) {
            return '<p>Aucune playlist pour le moment.
                <a href="?action=add-playlist">Créer une playlist</a>
            </p>';
        }
        
        $playlist = $_SESSION['playlist'];

        $renderer = new AudioListRenderer($playlist);

        $html = $renderer->render(1);

        if ($playlist->id !== null) {
            $html .= '<p><a href="?action=add-track">Ajouter une piste</a></p>';
        }

        return $html;
    }
}
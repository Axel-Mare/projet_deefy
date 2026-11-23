<?php

namespace iutnc\deefy\action;

use iutnc\deefy\render\AudioListRenderer;

class DisplayPlaylistAction extends Action
{
    public function execute(): string
    {
        session_start();

        if (!isset($_SESSION['playlist'])) {
            return '<p>Aucune playlist pour le moment.
                <a href="?action=add-playlist">Créer une playlist</a>
            </p>';
        }
        
        $playlist = $_SESSION['playlist'];

        $renderer = new AudioListRenderer($playlist);

        return $renderer->render(1);
    }
}
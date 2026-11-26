<?php

namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;

class ListPlaylistsAction extends Action
{
    public function execute(): string
    {
        $playlists = DeefyRepository::getInstance()->findAllPlaylists();

        if (empty($playlists)) {
            return '<p>Aucune playlist en base.</p>';
        }

        $html = '<h2>Mes playlists</h2><ul>';

        foreach ($playlists as $pl) {
            $nom = htmlspecialchars($pl->nom, ENT_QUOTES, 'UTF-8');
            $html .= '<li>' . $nom . '</li>';
        }

        return $html . '</ul>';
    }
}

<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\render\AudioListRenderer;

class AddPlaylistAction extends Action
{
    public function execute(): string
    {
        if ($this->http_method === 'GET') {
            return <<<HTML
                <form method="post" action="?action=add-playlist">
                    <label>Nom de la playlist :</label>
                    <input type="text" name="nom" required>
                    <button type="submit">Créer</button>
                </form>
            HTML;
        }

        $nom = trim($_POST['nom'] ?? '');

        if ($nom === '') {
            return '<p>Veuillez entrer un nom de playlist.</p>';
        }

        $playlist = new Playlist($nom);
        $playlist = DeefyRepository::getInstance()->saveEmptyPlaylist($playlist);

        $_SESSION['playlist'] = $playlist;

        $renderer = new AudioListRenderer($playlist);

        return $renderer->render(1) . '<a href="?action=add-track">Ajouter une piste</a>';
    }
}

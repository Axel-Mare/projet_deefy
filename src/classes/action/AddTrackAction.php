<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class AddTrackAction extends Action
{
    public function execute(): string
    {
        if (!isset($_SESSION['playlist'])) {
            return '<p>Aucune playlist.
                <a href="?action=playlists">Mes playlists</a> |
                <a href="?action=add-playlist">Créer une playlist</a>
            </p>';
        }

        if ($this->http_method === 'GET') {
            return $this->renderForm();
        }

        $type = $_POST['type'] ?? '';
        $titre = trim($_POST['titre'] ?? '');
        $genre = trim($_POST['genre'] ?? '');
        $duree = filter_var($_POST['duree'] ?? null, FILTER_VALIDATE_INT);
        $filename = trim($_POST['filename'] ?? '');

        if ($titre === '' || $filename === ''
            || $duree === false || $duree === null || $duree < 0) {
            return '<p>Informations invalides.</p>' . $this->renderForm();
        }

        if ($type === 'titre') {
            $artiste = trim($_POST['artiste'] ?? '');
            $album = trim($_POST['album'] ?? '');
            $annee = filter_var($_POST['annee'] ?? null, FILTER_VALIDATE_INT);
            $numero = filter_var($_POST['numero'] ?? null, FILTER_VALIDATE_INT);

            if ($artiste === '' || $album === '' || $annee === false
                || $annee === null || $numero === false || $numero === null) {
                return '<p>Informations titre invalides.</p>' . $this->renderForm();
            }

            $track = new AlbumTrack($titre, $album, $numero, $filename);
            $track->setArtiste($artiste);
            $track->setAnnee($annee);
        } elseif ($type === 'podcast') {
            $auteur = trim($_POST['auteur'] ?? '');
            $date = trim($_POST['date'] ?? '');

            if ($auteur === '' || $date === '' || !strtotime($date)) {
                return '<p>Informations podcast invalides.</p>' . $this->renderForm();
            }

            $track = new PodcastTrack($titre, $filename);
            $track->setAuteur($auteur);
            $track->setDate($date);
        } else {
            return '<p>Type de piste invalide.</p>' . $this->renderForm();
        }

        if ($genre !== '') {
            $track->setGenre($genre);
        }
        $track->setDuree($duree);

        if ($_SESSION['playlist']->id === null) {
            return '<p>Cette playlist n\'est pas enregistrée en base.</p>';
        }

        $repo = DeefyRepository::getInstance();
        $repo->saveTrack($track);
        $repo->addTrackToPlaylist($_SESSION['playlist']->id, $track->id);

        $_SESSION['playlist'] = $repo->findPlaylist($_SESSION['playlist']->id);

        $renderer = new AudioListRenderer($_SESSION['playlist']);

        return $renderer->render(1)
            . '<p><a href="?action=add-track">Ajouter encore une piste</a></p>';
    }

    private function renderForm(): string
    {
        return <<<HTML
            <form method="post" action="?action=add-track">
                <fieldset>
                    <legend>Type de piste</legend>
                    <label><input type="radio" name="type" value="titre" checked> Titre</label>
                    <label><input type="radio" name="type" value="podcast"> Podcast</label>
                </fieldset>

                <label>Titre :</label>
                <input type="text" name="titre" required>

                <label>Genre :</label>
                <input type="text" name="genre">

                <label>Durée en secondes :</label>
                <input type="number" name="duree" min="0" required>

                <label>Fichier :</label>
                <input type="text" name="filename" required>

                <fieldset>
                    <legend>Titre</legend>
                    <label>Artiste :</label>
                    <input type="text" name="artiste">

                    <label>Album :</label>
                    <input type="text" name="album">

                    <label>Année :</label>
                    <input type="number" name="annee">

                    <label>Numéro de piste :</label>
                    <input type="number" name="numero" min="0">
                </fieldset>

                <fieldset>
                    <legend>Podcast</legend>
                    <label>Auteur :</label>
                    <input type="text" name="auteur">

                    <label>Date :</label>
                    <input type="date" name="date">
                </fieldset>

                <button type="submit">Ajouter</button>
            </form>
        HTML;
    }
}

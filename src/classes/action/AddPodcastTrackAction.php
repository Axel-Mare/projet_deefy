<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\render\AudioListRenderer;

class AddPodcastTrackAction extends Action
{
    public function execute(): string
    {
        session_start();

        if (!isset($_SESSION['playlist'])) {
            return '<p>Aucune playlist. 
                <a href="?action=add-playlist">Créer une playlist</a>
            </p>';
        }

        if ($this->http_method === 'GET') {
            return <<<HTML
                <form method="post" action="?action=add-track"
                      enctype="multipart/form-data">
                    <label>Titre :</label>
                    <input type="text" name="titre" required>

                    <label>Auteur :</label>
                    <input type="text" name="auteur" required>

                    <label>Date :</label>
                    <input type="date" name="date" required>

                    <label>Durée en secondes :</label>
                    <input type="number" name="duree" min="0" required>

                    <label>Fichier MP3 :</label>
                    <input type="file" name="userfile" accept=".mp3" required>

                    <button type="submit">Ajouter</button>
                </form>
            HTML;
        }

        $titre = trim($_POST['titre'] ?? '');
        $auteur = trim($_POST['auteur'] ?? '');
        $date = $_POST['date'] ?? '';
        $duree = filter_var($_POST['duree'] ?? null, FILTER_VALIDATE_INT);

        if ($titre === '' || $auteur === '' || $date === ''
            || $duree === false || $duree === null || $duree < 0) {
            return '<p>Informations invalides.</p>';
        }

        $fichier = $_FILES['userfile'];

        if (
            $fichier['error'] !== UPLOAD_ERR_OK ||
            strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION)) !== 'mp3' ||
            $fichier['type'] !== 'audio/mpeg'
        ) {
            return '<p>Fichier MP3 invalide.</p>';
        }

        $nomFichier = uniqid() . '.mp3';

        if (!move_uploaded_file(
            $fichier['tmp_name'],
            __DIR__ . '/../../audio/' . $nomFichier
        )) {
            return '<p>Erreur enregistrement du fichier.</p>';
        }

        $track = new PodcastTrack($titre, 'audio/' . $nomFichier);
        $track->setAuteur($auteur);
        $track->setDate($date);
        $track->setDuree($duree);

        $_SESSION['playlist']->addTrack($track);

        $renderer = new AudioListRenderer($_SESSION['playlist']);

        return $renderer->render(1)
            . '<a href="?action=add-track">Ajouter encore une piste</a>';
    }
}
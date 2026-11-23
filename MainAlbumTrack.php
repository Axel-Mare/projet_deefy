<?php

require('vendor/autoload.php');

use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;

use iutnc\deefy\audio\lists\AudioList;
use iutnc\deefy\audio\lists\Album;
use iutnc\deefy\audio\lists\Playlist;

use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\render\AlbumTrackRenderer;
use iutnc\deefy\render\PodcastRenderer;
use iutnc\deefy\render\Renderer;

$track1 = new AlbumTrack('Bohemian Rhapsody', 'A Night at the Opera', 1, 'bohemian_rhapsody.mp3');
$track2 = new AlbumTrack('Stairway to Heaven', 'Led Zeppelin IV', 2, 'stairway_to_heaven.mp3');

$podcast1 = new PodcastTrack('The Joe Rogan Experience', 'joe_rogan_experience.mp3');

print_r($track1);
echo "<br>";
print_r($track2);
echo "<br>";
print_r($podcast1);
echo "<br>";

echo $track1->__toString()."<br>";
echo $track2->__toString()."<br>";
echo $podcast1->__toString()."<br>";

$r = new AlbumTrackRenderer($track1);
echo $r->render(Renderer::COMPACT);
echo $r->render(Renderer::LONG)."<br>";

$pr = new PodcastRenderer($podcast1);
echo $pr->render(Renderer::COMPACT);
echo $pr->render(Renderer::LONG)."<br>";

echo "-----------------------------------------------------------------------------------------<br>";

$track = new AudioTrack("Ma musique", "musique.mp3");
echo $track->titre;
echo "<br>";
echo $track->fichier;

echo "<br>-----------------------------------------------------------------------------------------<br>";

$track1 = new AudioTrack("Musique 1", "musique1.mp3");
$track2 = new AudioTrack("Musique 2", "musique2.mp3");

$track1->setDuree(120);
$track2->setDuree(180);

$list = new AudioList("Ma liste", [$track1, $track2]);

echo $list->nom;
echo "<br>";
echo $list->nb_piste;
echo "<br>";
echo $list->duree;

echo "<br>-----------------------------------------------------------------------------------------<br>";

$playlist = new Playlist("Ma playlist");
$playlist->addTrack($track1);
$playlist->addTrack($track2);

echo $playlist->nb_piste;
echo "<br>";
echo $playlist->duree;

echo "<br>-----------------------------------------------------------------------------------------<br>";

$playlist->removeTrack(0);

echo $playlist->nb_piste;
echo "<br>";
echo $playlist->duree;

echo "<br>-----------------------------------------------------------------------------------------<br>";

$renderer = new AudioListRenderer($playlist);

echo $renderer->render(1);
?>
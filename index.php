<?php

require_once __DIR__ . '/vendor/autoload.php';

use iutnc\deefy\dispatch\Dispatcher;
use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\DisplayPlaylistAction;
use iutnc\deefy\action\AddPlaylistAction;
use iutnc\deefy\action\AddTrackAction;
use iutnc\deefy\action\ListPlaylistsAction;
use iutnc\deefy\repository\DeefyRepository;

session_start();
DeefyRepository::setConfig(__DIR__ . '/db.config.ini');

$dispatcher = new Dispatcher();

$dispatcher->addRoute('default', DefaultAction::class);
$dispatcher->addRoute('playlists', ListPlaylistsAction::class);
$dispatcher->addRoute('playlist', DisplayPlaylistAction::class);
$dispatcher->addRoute('add-playlist', AddPlaylistAction::class);
$dispatcher->addRoute('add-track', AddTrackAction::class);

$dispatcher->run();
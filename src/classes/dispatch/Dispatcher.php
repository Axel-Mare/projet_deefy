<?php

namespace iutnc\deefy\dispatch;

use iutnc\deefy\action\DefaultAction;

class Dispatcher
{
    private string $action;
    private array $routes = [];

    public function __construct()
    {
        $this->action = $_GET['action'] ?? 'default';
    }

    public function addRoute(string $action, string $class): self
    {
        $this->routes[$action] = $class;

        return $this;
    }

    public function run(): void
    {
        $class = $this->routes[$this->action] ?? $this->routes['default'];

        $action = new $class();

        $this->renderPage($action->execute());
    }

    private function renderPage(string $html): void
    {
        echo <<<HTML
            <!DOCTYPE html>
            <html lang="fr">
            <head>
            <meta charset="UTF-8">
            <title>DeefyApp</title>
            </head>
            <body>
                <h1>DeefyApp</h1>

                <nav>
                    <a href="?action=default">Accueil</a> |
                    <a href="?action=playlists">Mes playlists</a> |
                    <a href="?action=playlist">Playlist courante</a> |
                    <a href="?action=add-playlist">Créer une playlist</a>
                </nav>

                <hr>

                <main>
                    $html
                </main>
            </body>
            </html>
        HTML;
    }
}

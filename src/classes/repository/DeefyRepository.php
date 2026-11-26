<?php

namespace iutnc\deefy\repository;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\audio\tracks\AlbumTrack;

class DeefyRepository
{
    private \PDO $pdo;
    private static ?DeefyRepository $instance = null;
    private static array $config = [];

    private function __construct(array $conf)
    {
        $this->pdo = new \PDO(
            $conf['dsn'],
            $conf['user'],
            $conf['pass'],
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
        );
    }

    public static function setConfig(string $file): void
    {
        $conf = parse_ini_file($file);

        if ($conf === false) {
            throw new \Exception("Erreur de lecture du fichier de configuration");
        }

        $dsn = "{$conf['driver']}:host={$conf['host']};dbname={$conf['database']};charset=utf8";

        self::$config = [
            'dsn' => $dsn,
            'user' => $conf['username'],
            'pass' => $conf['password']
        ];
    }

    public static function getInstance(): DeefyRepository
    {
        if (self::$instance === null) {
            self::$instance = new DeefyRepository(self::$config);
        }

        return self::$instance;
    }

    public function findPlaylist(int $id): ?Playlist
    {
        $stmt = $this->pdo->prepare('SELECT id, nom FROM playlist WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        $pl = new Playlist($row['nom']);
        $pl->id = (int) $row['id'];

        $stmt = $this->pdo->prepare(
            'SELECT t.* FROM track t
             JOIN playlist2track pt ON pt.id_track = t.id
             WHERE pt.id_pl = :id
             ORDER BY pt.no_piste_dans_liste'
        );
        $stmt->execute(['id' => $id]);

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $pl->addTrack($this->createTrack($row));
        }

        return $pl;
    }

    private function createTrack(array $row)
    {
        if ($row['type'] === 'A') {
            $track = new AlbumTrack(
                $row['titre'],
                $row['titre_album'] ?? '',
                (int) ($row['numero_album'] ?? 0),
                $row['filename'] ?? ''
            );
            $track->setArtiste($row['artiste_album'] ?? '');
            $track->setAnnee((int) ($row['annee_album'] ?? 0));
        } else {
            $track = new PodcastTrack($row['titre'], $row['filename'] ?? '');
            $track->setAuteur($row['auteur_podcast'] ?? '');
            $track->setDate($row['date_posdcast'] ?? '');
        }

        if ($row['genre'] !== null) {
            $track->setGenre($row['genre']);
        }
        if ($row['duree'] !== null) {
            $track->setDuree((int) $row['duree']);
        }

        $track->id = (int) $row['id'];

        return $track;
    }

    public function findAllPlaylists(): array
    {
        $stmt = $this->pdo->query('SELECT id, nom FROM playlist');
        $playlists = [];

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $pl = new Playlist($row['nom']);
            $pl->id = (int) $row['id'];
            $playlists[] = $pl;
        }

        return $playlists;
    }

    public function saveEmptyPlaylist(Playlist $pl): Playlist
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO playlist (nom) VALUES (:nom)'
        );

        $stmt->execute(['nom' => $pl->nom]);
        $pl->id = (int) $this->pdo->lastInsertId();

        return $pl;
    }

    public function saveTrack($track)
    {
        if ($track instanceof PodcastTrack) {
            $stmt = $this->pdo->prepare(
                'INSERT INTO track
                (titre, filename, genre, duree, type, auteur_podcast, date_posdcast)
                VALUES (:titre, :filename, :genre, :duree, :type, :auteur, :date)'
            );

            $stmt->execute([
                'titre' => $track->titre,
                'filename' => $track->fichier,
                'genre' => $track->genre,
                'duree' => $track->duree,
                'type' => 'P',
                'auteur' => $track->auteur,
                'date' => $track->date
            ]);
        } elseif ($track instanceof AlbumTrack) {
            $stmt = $this->pdo->prepare(
                'INSERT INTO track
                (titre, filename, genre, duree, type, artiste_album, titre_album, annee_album, numero_album)
                VALUES (:titre, :filename, :genre, :duree, :type, :artiste, :album, :annee, :numero)'
            );

            $stmt->execute([
                'titre' => $track->titre,
                'filename' => $track->fichier,
                'genre' => $track->genre,
                'duree' => $track->duree,
                'type' => 'A',
                'artiste' => $track->artiste,
                'album' => $track->album,
                'annee' => $track->annee,
                'numero' => $track->num
            ]);
        } else {
            throw new \InvalidArgumentException('Type de piste inconnu');
        }

        $track->id = (int) $this->pdo->lastInsertId();

        return $track;
    }
    
    public function addTrackToPlaylist(int $idPl, int $idTrack): void
    {
        $stmt = $this->pdo->prepare(
            'SELECT COALESCE(MAX(no_piste_dans_liste), 0) + 1
             FROM playlist2track
             WHERE id_pl = :id'
        );

        $stmt->execute(['id' => $idPl]);
        $numero = (int) $stmt->fetchColumn();

        $stmt = $this->pdo->prepare(
            'INSERT INTO playlist2track (id_pl, id_track, no_piste_dans_liste)
             VALUES (:idPl, :idTrack, :numero)'
        );

        $stmt->execute([
            'idPl' => $idPl,
            'idTrack' => $idTrack,
            'numero' => $numero
        ]);
    }
}

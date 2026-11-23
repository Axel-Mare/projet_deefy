<?php
namespace iutnc\deefy\audio\lists;
use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\exception\InvalidPropertyNameException;

class Playlist extends AudioList {
    
    private int $id;

    public function addTrack(AudioTrack $track): void
    {
        $this->tracks[] = $track;
        $this->nb_piste++;
        $this->duree += $track->duree;
    }

    public function removeTrack(int $index): void
    {
        if (!isset($this->tracks[$index])) {
            return;
        }
        $track = $this->tracks[$index];

        unset($this->tracks[$index]);
        $this->tracks = array_values($this->tracks);
        $this->nb_piste--;
        $this->duree -= $track->duree;
    }

    public function addTracks(array $tracks): void
    {
        foreach ($tracks as $track) {
            if ($track instanceof AudioTrack && !in_array($track, $this->tracks)) {
                $this->addTrack($track);
            }
        }
    }

    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) {
            return $this->$at;
        }

        throw new InvalidPropertyNameException("invalid property : $at");
    }
}
    
?>
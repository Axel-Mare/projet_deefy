<?php
namespace iutnc\deefy\audio\lists;
use iutnc\deefy\audio\tracks\AudioTrack;

class Playlist extends AudioList {
    
    public ?int $id = null;

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
}
    
?>
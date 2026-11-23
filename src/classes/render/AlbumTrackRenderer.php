<?php
namespace iutnc\deefy\render;
use iutnc\deefy\audio\tracks\AlbumTrack;

class AlbumTrackRenderer extends AudioTrackRenderer {

    public function __construct(
        public AlbumTrack $track){  
    }

    protected function renderCompact(): string
    {
        return
                '<h2>' . $this->track->titre . '</h2>
                <audio controls>
                    <source src="' . $this->track->fichier . '" type="audio/mpeg">
                </audio>';
    }

    protected function renderLong(): string
    {
        return
                '<h2>' . $this->track->titre . '</h2>
                <p>Album : ' . $this->track->album . '</p>
                <p>Piste n°' . $this->track->num . '</p>
                <audio controls>
                    <source src="' . $this->track->fichier . '" type="audio/mpeg">
                </audio>';
    }
}

?>
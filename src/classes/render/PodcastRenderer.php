<?php
namespace iutnc\deefy\render;
use \iutnc\deefy\audio\tracks\PodcastTrack;

class PodcastRenderer extends AudioTrackRenderer{

    public function __construct(
        public PodcastTrack $podcast){  
    }

    protected function renderCompact(): string
    {
        return
                '<h2>' . $this->podcast->titre . '</h2>
                <audio controls>
                    <source src="' . $this->podcast->fichier . '" type="audio/mpeg">
                </audio>';
    }

    protected function renderLong(): string
    {
        return 
                '<h2>' . $this->podcast->titre . '</h2>
                <p>Auteur : ' . $this->podcast->auteur . '</p>
                <p>Date : ' . $this->podcast->date . '</p>
                <audio controls>
                    <source src="' . $this->podcast->fichier . '" type="audio/mpeg">
                </audio>';
    }

}

?>
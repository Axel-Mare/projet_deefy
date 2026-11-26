<?php

namespace iutnc\deefy\audio\tracks;

class PodcastTrack extends AudioTrack {
    
    protected string $auteur = '';
    protected string $date = '';

    public function __construct(string $titre, string $fichier)
    {
        parent::__construct($titre, $fichier);
    }

    public function setAuteur(string $aut)
    {
        return $this->auteur = $aut;
    }

    public function setDate(string $dte)
    {
        return $this->date = $dte;
    }
}
    
?>
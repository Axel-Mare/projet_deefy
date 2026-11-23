<?php

namespace iutnc\deefy\audio\tracks;

class PodcastTrack extends AudioTrack {
    
    private string $auteur = '';
    private string $date = '';
        
    public function __construct(
        private $titre, 
        private $fichier
    ) {
        parent::__construct($titre,$fichier);
    }

    public function __get(string $attrname): mixed
    {
        if (property_exists($this, $attrname)) {
            return $this->$attrname;
        }
        //throw new \Exception("invalid property : " . $attrname);
        return parent::__get($attrname);
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
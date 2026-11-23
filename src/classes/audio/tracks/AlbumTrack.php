<?php
namespace iutnc\deefy\audio\tracks;
use iutnc\deefy\exception\InvalidPropertyNameException;

class AlbumTrack extends AudioTrack {
    
    private string $artiste;
    private int $annee;
        
    public function __construct(
        string $titre, 
        protected string $album, 
        protected int $num, 
        string $fichier
    ) {
        parent::__construct($titre,$fichier);
    }

    public function setArtiste(string $art)
    {
        return $this->artiste = $art;
    }

    public function setAnnee(string $year)
    {
        return $this->annee = $year;
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
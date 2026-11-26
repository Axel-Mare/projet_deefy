<?php
namespace iutnc\deefy\audio\tracks;

class AlbumTrack extends AudioTrack {
    
    protected string $artiste = '';
    protected int $annee = 0;
        
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

    public function setAnnee(int $annee): void
    {
        $this->annee = $annee;
    }

}
    
?>
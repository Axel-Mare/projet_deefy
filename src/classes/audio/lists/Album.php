<?php
namespace iutnc\deefy\audio\lists;

class Album extends AudioList {
    
    private string $artiste;
    private int $dateSortie;
        
    public function __construct(
        string $nom, 
        array $tracks
    ) {
        parent::__construct($nom,$tracks);
    }

    public function setArtiste(string $art): void
    {
        $this->artiste = $art;
    }

    public function setDateSortie(int $dSortie): void
    {
        $this->dateSortie = $dSortie;
    }
}
    
?>
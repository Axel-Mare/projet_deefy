<?php
namespace iutnc\deefy\audio\lists;
use iutnc\deefy\exception\InvalidPropertyNameException;
use iutnc\deefy\audio\tracks\AudioTrack;

class AudioList {
    
    private string $nom;
    protected int $nb_piste;
    protected int $duree;
    protected array $tracks;

    public function __construct(
        string $nom,
        array $tracks = []
    ) {
        $this->nom = $nom;
        $this->tracks = $tracks;
        $this->nb_piste = count($tracks);

        $this->duree = 0;

        foreach ($tracks as $track) {
            if ($track instanceof AudioTrack){
                $this->duree += $track->duree;
            }
        
        }
    }

    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) {
            return $this->$at;
        }
        throw new InvalidPropertyNameException(
            "invalid property : $at"
        );
    }
}

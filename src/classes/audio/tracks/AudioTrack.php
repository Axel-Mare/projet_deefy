<?php
namespace iutnc\deefy\audio\tracks;
use iutnc\deefy\exception\InvalidPropertyValueException;
use iutnc\deefy\exception\InvalidPropertyNameException;

class AudioTrack {
    
    private string $genre;
    private int $duree;
    private int $id;

    public function __construct(
        private string $titre,//on peut faire (public string $titre et ne pas le remettre en dessous)
        private string $fichier
    ) {}

    public function __toString() {
        return json_encode(get_object_vars($this));
    }

    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) {
            return $this->$at;
        }

        throw new InvalidPropertyNameException("invalid property : $at");
    }

    public function setGenre(string $gre)
    {
        return $this->genre = $gre;
    }

    public function setDuree(int $duree): void
    {
        if ($duree < 0) {
            throw new InvalidPropertyValueException(
                "invalid property value : duree"
            );
        }

        $this->duree = $duree;
    }
}
?>
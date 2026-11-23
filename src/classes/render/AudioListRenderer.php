<?php
namespace iutnc\deefy\render;
use \iutnc\deefy\audio\lists\AudioList;

class AudioListRenderer implements Renderer {

    public function __construct(
        private AudioList $list, 
    ) {}

    public function render(int $selector): string {
        $rep = "<h2>" . $this->list->nom . "</h2>\n";
        
        foreach ($this->list->tracks as $track)
            $rep .= '<strong>' . $track->titre . '</strong><br>
                <audio controls>
                    <source src="' . $track->fichier . '" type="audio/mpeg">
                </audio>';
        $rep .= "<p>Nombre de pistes : " . $this->list->nb_piste . "</p>\n";
        $rep .= "<p>Durée totale : " . $this->list->duree . "</p>\n";
        return $rep;
    }

}
?>
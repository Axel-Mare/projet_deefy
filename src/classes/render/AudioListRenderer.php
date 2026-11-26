<?php
namespace iutnc\deefy\render;
use \iutnc\deefy\audio\lists\AudioList;

class AudioListRenderer implements Renderer {

    public function __construct(
        private AudioList $list, 
    ) {}

    public function render(int $selector): string {
        $rep = "<h2>" . htmlspecialchars($this->list->nom, ENT_QUOTES, 'UTF-8') . "</h2>\n";

        foreach ($this->list->tracks as $track)
            $rep .= '<strong>' . htmlspecialchars($track->titre, ENT_QUOTES, 'UTF-8') . '</strong><br>
                <audio controls>
                    <source src="' . htmlspecialchars($track->fichier, ENT_QUOTES, 'UTF-8') . '" type="audio/mpeg">
                </audio>';
        $rep .= "<p>Nombre de pistes : " . $this->list->nb_piste . "</p>\n";
        $rep .= "<p>Durée totale : " . $this->list->duree . "</p>\n";
        return $rep;
    }

}
?>
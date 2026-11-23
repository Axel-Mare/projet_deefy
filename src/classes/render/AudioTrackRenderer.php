<?php
namespace iutnc\deefy\render;

abstract class AudioTrackRenderer implements Renderer {

    public function render(int $selector): string {
        switch ($selector) {
            case self::COMPACT:
                return $this->renderCompact();

            case self::LONG:
                return $this->renderLong();

            default:
                return "Mode d'affichage inconnu";
        }
    }

    abstract protected function renderCompact(): string;
    abstract protected function renderLong(): string;
}
?>
<?php
namespace App\Entity;
class Recherche
{
    private $titre;  // juste pour permettre à l'utilisateur d'entrer sa recherche
    public function getTitre(): ?string
    {
        return $this->titre;
    }
    public function setTitre(string $titre): self
    {
    $this->titre = $titre;
        return $this;
    }
}
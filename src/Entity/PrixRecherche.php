<?php
namespace App\Entity;
class PrixRecherche
{
/**
    * @var int|null
    */

    private $minPrix;
    /**
    * @var int|null
    */
    private $maxPrix;

    public function getMinPrix(): ?int
    {
         return $this->minPrix;
    }
    public function setMinPrix(int $minPrix): self
    {
    $this->minPrix = $minPrix;
         return $this;
    }
    public function getMaxPrix(): ?int
    {
         return $this->maxPrix;
    }
    public function setMaxPrix(int $maxPrix): self
    {
    $this->maxPrix = $maxPrix;
         return $this;
    }
}
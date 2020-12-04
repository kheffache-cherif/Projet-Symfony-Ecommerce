<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class CategoriesRecherche
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories")
     */

     //les valeurs de categories sont des objets de Categories class
    private $Categories;


    public function getCategories(): ?Categories
    {
        return $this->Categories;
    }

    public function setCategories(?Categories $Categories): self
    {
        $this->Categories = $Categories;

        return $this;
    }



}
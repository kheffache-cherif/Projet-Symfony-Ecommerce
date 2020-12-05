<?php

namespace App\Entity;

use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\MembresRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
    * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
    * @UniqueEntity(
    *   fields={"email"},
    * message="L'émail que vous avez tapé est déjà utilisé !"
    * )
    */
class Membres implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email; 

    /**
    * @ORM\Column(type="string", length=255)
    * @Assert\Length(
    * min = 8,
    * minMessage = "Votre mot de passe doit comporter au minimum {{ limit }} caractères")
    * @Assert\EqualTo(propertyPath = "confirm_password",
    * message="Vous n'avez pas saisi le même mot de passe !" )
    */
    private $password;

    /**
    * @Assert\EqualTo(propertyPath = "password",
    * message="Vous n'avez pas saisile même mot de passe !" )
    */

    private $confirm_password; 
    public function getConfirmPassword()
    {
        return $this->confirm_password;
    }

    public function setConfirmPassword($confirm_password)
    {
        $this->confirm_password = $confirm_password;

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles()
{
return ['ROLE_USER'];
}
public function eraseCredentials() {}
public function getSalt() {}
public function getUsername() {}

}

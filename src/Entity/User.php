<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *  fields={"email"}
 * )
 */
class User implements UserInterface 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="4",  minMessage="Votre mot de passe de doit faire 4 caractere au minimum")
     */
    private $password;
    /**
     * @Assert\Length(min="4",  minMessage="Votre mot de passe de doit faire 4 caractere au minimum")
     * @Assert\EqualTo(propertyPath="password" , message="Ce n'est pas le mem mot de passe")
     */
    public $confirm_password;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    // les fonctions de l'interface UserInterface (On l'utilise pour indiquer a symfony que User est bien une classe utilisateur afin de pouvoir crypter les mot de passe lors d'une inscription)
    public function eraseCredentials(){}
    public function getSalt(){}
    public function getRoles() {
        // Quel est le rou de cet utilisateur (administrateur? ou simple utilisateur?)
        return ['ROLE_USER'];
    }

}

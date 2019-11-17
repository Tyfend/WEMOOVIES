<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="Nom d'utilisateur non disponible")
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
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(
     *   min = 5,
     *   max = 100,
     *   minMessage = "L'adresse mail doit avoir au moins 5 caractères",
     *   maxMessage = "L'adresse mail doit avoir au plus 100 caractères"
     * )
     * @Assert\Email(message = "Merci d'entrer une adresse email valide")
     * @Assert\NotBlank(message = "Adresse email obligatoire !")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(
     *   min = 2,
     *   max = 100,
     *   minMessage = "Le nom doit avoir au moins 5 caractères",
     *   maxMessage = "Le nom doit avoir au plus 100 caractères"
     * )
     * @Assert\NotBlank(message = "Nom obligatoire !")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *   min = 8,
     *   minMessage = "Le mot de passe doit avoir au moins 8 caractères"
     * )
    * @Assert\EqualTo(
    *   propertyPath = "confirm_password",
    *   message = "Les 2 mots de passe doivent correspondre",
    * )
    * @Assert\NotBlank(message = "Mot de passe obligatoire !")
     */
    private $password;

    /**
     * @Assert\EqualTo(
     *  propertyPath = "password",
     *  message = "Les 2 mots de passe doivent correspondre",
     * )
     * @Assert\NotBlank(message = "Mot de passe obligatoire !")
     */
    public $confirm_password;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = [];

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

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles(){
        
        return ['ROLE_USER'];
        // return ['ROLE_ADMIN'];
    }

    public function setRoles($roles): self
    {

    }
    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt(){}
 
    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials(){}
}

<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * Attribute 'id' secured with Assert
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Attribute 'title' secured with Assert
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(min=10, max=50, exactMessage="Le titre doit être comprit entre 10 et 50 caractères")
     * Assert\NotBlank
     */
    private $title;

    /**
     * Attribute 'content' secured with Assert
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=50, max=255, exactMessage="Le contenu doit être comprit entre 50 et 255 caractères")
     * Assert\NotBlank
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * all GETTER and SETTER from Article object
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}

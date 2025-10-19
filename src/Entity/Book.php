<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $published = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Auther $Auther = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(length: 100)]
    private ?string $ref = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $publicationDate = null;

    #[ORM\Column(length: 40)]
    private ?string $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): static
    {
        $this->published = $published;

        return $this;
    }

    public function getAuther(): ?Auther
    {
        return $this->Auther;
    }

    public function setAuther(?Auther $Auther): static
    {
        $this->Auther = $Auther;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): static
    {
        $this->ref = $ref;

        return $this;
    }

    public function getPublicationDate(): ?\DateTime
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTime $publicationDate): static
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }
}

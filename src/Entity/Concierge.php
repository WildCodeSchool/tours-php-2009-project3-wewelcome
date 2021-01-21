<?php

namespace App\Entity;

use App\Repository\ConciergeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConciergeRepository::class)
 */
class Concierge
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $photo = null;

    /**
     * @ORM\Column(type="string", length=1500, nullable=true)
     */
    private ?string $text = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $relatedTo;

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getRelatedTo(): ?string
    {
        return $this->relatedTo;
    }

    public function setRelatedTo(string $relatedTo): self
    {
        $this->relatedTo = $relatedTo;

        return $this;
    }
}

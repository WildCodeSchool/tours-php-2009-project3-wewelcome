<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 */
class Service
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
    private string $logo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $logoTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $photo;

    /**
     * @ORM\Column(type="string", length=1500)
     */
    private string $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $relatedTo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getLogoTitle(): ?string
    {
        return $this->logoTitle;
    }

    public function setLogoTitle(string $logoTitle): self
    {
        $this->logoTitle = $logoTitle;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

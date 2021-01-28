<?php

namespace App\Entity;

use App\Repository\FooterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FooterRepository::class)
 */
class Footer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private ?string $title = '';

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $phone = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $logo = '';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $url = '';

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isSocialNetwork;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private ?string $text = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getIsSocialNetwork(): ?bool
    {
        return $this->isSocialNetwork;
    }

    public function setIsSocialNetwork(bool $isSocialNetwork): self
    {
        $this->isSocialNetwork = $isSocialNetwork;

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
}

<?php

namespace App\Entity;

use App\Repository\HomeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=HomeRepository::class)
 */
class Home
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} charactères",
     *      maxMessage = "Votre texte ne peut pas faire plus de {{ limit }} charactères"
     * )
     */
    private string $title = "";

    /**
     * @ORM\Column(type="string", length=800, nullable=true)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 800,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} charactères",
     *      maxMessage = "Votre texte ne peut pas faire plus de {{ limit }} charactères"
     * )
     */
    private ?string $text = "";

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez choisir une photo")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le chemin du dossier est trop long, il dépasse {{ limit }} charactères"
     * )
     */
    private string $pictureOne = "";

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Vous devez choisir une photo")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le chemin du dossier est trop long, il dépasse {{ limit }} charactères"
     * )
     */
    private ?string $pictureTwo = "";

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Vous devez choisir une photo")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le chemin du dossier est trop long, il dépasse {{ limit }} charactères"
     * )
     */
    private ?string $pictureThree = "";

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $type = "";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "Votre texte ne peut pas faire plus de {{ limit }} charactères"
     * )
     */
    private ?string $legendPictureOne = "";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "Votre texte ne peut pas faire plus de {{ limit }} charactères"
     * )
     */
    private ?string $legendPictureTwo = "";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "Votre texte ne peut pas faire plus de {{ limit }} charactères"
     * )
     */
    private ?string $legendPictureThree = "";

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getPictureOne(): ?string
    {
        return $this->pictureOne;
    }

    public function setPictureOne(string $pictureOne): self
    {
        $this->pictureOne = $pictureOne;

        return $this;
    }

    public function getPictureTwo(): ?string
    {
        return $this->pictureTwo;
    }

    public function setPictureTwo(?string $pictureTwo): self
    {
        $this->pictureTwo = $pictureTwo;

        return $this;
    }

    public function getPictureThree(): ?string
    {
        return $this->pictureThree;
    }

    public function setPictureThree(?string $pictureThree): self
    {
        $this->pictureThree = $pictureThree;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLegendPictureOne(): ?string
    {
        return $this->legendPictureOne;
    }

    public function setLegendPictureOne(?string $legendPictureOne): self
    {
        $this->legendPictureOne = $legendPictureOne;

        return $this;
    }

    public function getLegendPictureTwo(): ?string
    {
        return $this->legendPictureTwo;
    }

    public function setLegendPictureTwo(?string $legendPictureTwo): self
    {
        $this->legendPictureTwo = $legendPictureTwo;

        return $this;
    }

    public function getLegendPictureThree(): ?string
    {
        return $this->legendPictureThree;
    }

    public function setLegendPictureThree(?string $legendPictureThree): self
    {
        $this->legendPictureThree = $legendPictureThree;

        return $this;
    }
}

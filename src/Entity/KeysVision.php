<?php

namespace App\Entity;

use App\Repository\KeysVisionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=KeysVisionRepository::class)
 */
class KeysVision
{
    public const GENRES = ['keys', 'vision'];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $photo;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private string $text1;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private string $text2;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private string $text3;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private string $text4;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private string $text5;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private string $text6;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private string $text7;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private string $text8;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Choice(choices=KeysVision::GENRES, message = "Type invalide")
     */
    private string $type;

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

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getText1(): ?string
    {
        return $this->text1;
    }

    public function setText1(string $text1): self
    {
        $this->text1 = $text1;

        return $this;
    }

    public function getText2(): ?string
    {
        return $this->text2;
    }

    public function setText2(string $text2): self
    {
        $this->text2 = $text2;

        return $this;
    }

    public function getText3(): ?string
    {
        return $this->text3;
    }

    public function setText3(string $text3): self
    {
        $this->text3 = $text3;

        return $this;
    }

    public function getText4(): ?string
    {
        return $this->text4;
    }

    public function setText4(string $text4): self
    {
        $this->text4 = $text4;

        return $this;
    }

    public function getText5(): ?string
    {
        return $this->text5;
    }

    public function setText5(string $text5): self
    {
        $this->text5 = $text5;

        return $this;
    }

    public function getText6(): ?string
    {
        return $this->text6;
    }

    public function setText6(string $text6): self
    {
        $this->text6 = $text6;

        return $this;
    }

    public function getText7(): ?string
    {
        return $this->text7;
    }

    public function setText7(string $text7): self
    {
        $this->text7 = $text7;

        return $this;
    }

    public function getText8(): ?string
    {
        return $this->text8;
    }

    public function setText8(string $text8): self
    {
        $this->text8 = $text8;

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
}

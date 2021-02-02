<?php

namespace App\Entity;

use App\Repository\LegalsTextsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=LegalsTextsRepository::class)
 */
class LegalsTexts
{
    public const GENRES = ['cgu', 'legal-notice'];

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
     *      max = 50,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=10000)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 10000,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private string $text;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice(choices=LegalsTexts::GENRES, message = "Type invalide")
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

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

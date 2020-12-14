<?php

namespace App\FormData;

use Symfony\Component\Validator\Constraints as Assert;

class MailMessageData
{
    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez choisir un sujet")
     * @Assert\Type(type="string")
     * @Assert\Length(max="255")
     */
    private $subject;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez saisir votre numéro de téléphone")
     * @Assert\Type(type="string")
     * @Assert\Length(max="25")
     */
    private $phone;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez saisir votre email")
     * @Assert\Email
     * @Assert\Length(max="100")
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez saisir votre prénom")
     * @Assert\Type(type="string")
     * @Assert\Length(max="50")
     */
    private $firstName;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez saisir votre nom")
     * @Assert\Type(type="string")
     * @Assert\Length(max="50")
     */
    private $lastName;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez saisir votre message")
     * @Assert\Type(type="string")
     * @Assert\Length(max="1500")
     */
    private $message;

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}

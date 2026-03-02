<?php

namespace App\Entity;

use App\Enum\EducationEnum;
use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[Id]
    #[GeneratedValue(strategy: 'IDENTITY')]
    #[Column(type: 'integer')]
    private int $id;

    #[Column(type: 'string', length: 255)]
    private string $firstName;
    #[Column(type: 'string', length: 255)]
    private string $lastName;
    #[Column(type: 'string', length: 20)]
    private string $phone;
    #[Column(type: 'string', length: 255, unique: true)]
    private string $email;
    #[Column(type: 'string', length: 25, enumType: EducationEnum::class)]
    private EducationEnum $educationType;
    #[Column(type: 'boolean')]
    private bool $isAgreement;
    #[Column(type: 'integer')]
    private int $scoring;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getEducationType(): EducationEnum
    {
        return $this->educationType;
    }

    public function setEducationType(EducationEnum $educationType): static
    {
        $this->educationType = $educationType;

        return $this;
    }

    public function isAgreement(): bool
    {
        return $this->isAgreement;
    }

    public function setIsAgreement(bool $isAgreement): static
    {
        $this->isAgreement = $isAgreement;

        return $this;
    }

    public function getScoring(): int
    {
        return $this->scoring;
    }

    public function setScoring(int $scoring): static
    {
        $this->scoring = $scoring;

        return $this;
    }
}

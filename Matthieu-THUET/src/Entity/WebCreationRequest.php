<?php

namespace App\Entity;

use App\Repository\WebCreationRequestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebCreationRequestRepository::class)]
class WebCreationRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $firstName = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $companyName = null;

    #[ORM\Column(length: 150)]
    private ?string $emailAddress = null;

    #[ORM\Column(length: 100)]
    private ?string $projectTitle = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $shortProjectDescription = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string $emailAddress): static
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    public function getProjectTitle(): ?string
    {
        return $this->projectTitle;
    }

    public function setProjectTitle(string $projectTitle): static
    {
        $this->projectTitle = $projectTitle;

        return $this;
    }

    public function getShortProjectDescription(): ?string
    {
        return $this->shortProjectDescription;
    }

    public function setShortProjectDescription(string $shortProjectDescription): static
    {
        $this->shortProjectDescription = $shortProjectDescription;

        return $this;
    }
}

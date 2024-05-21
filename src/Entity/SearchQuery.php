<?php

namespace App\Entity;

use App\Repository\SearchQueryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SearchQueryRepository::class)]
class SearchQuery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $targetLocation;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $arrivalDate = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $accomodationBudget = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $restaurationBudget = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $eventsBudget = null;

    #[ORM\ManyToOne(inversedBy: 'searchQueries')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTargetLocation(): ?string
    {
        return $this->targetLocation;
    }

    public function setTargetLocation(string $targetLocation): static
    {
        $this->targetLocation = $targetLocation;

        return $this;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(\DateTimeInterface $arrivalDate): static
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    public function getAccomodationBudget(): ?int
    {
        return $this->accomodationBudget;
    }

    public function setAccomodationBudget(?int $accomodationBudget): self
    {
        $this->accomodationBudget = $accomodationBudget;

        return $this;
    }

    public function getRestaurationBudget(): ?int
    {
        return $this->restaurationBudget;
    }

    public function setRestaurationBudget(?int $restaurationBudget): self
    {
        $this->restaurationBudget = $restaurationBudget;

        return $this;
    }

    public function getEventsBudget(): ?int
    {
        return $this->eventsBudget;
    }

    public function setEventsBudget(?int $eventsBudget): self
    {
        $this->eventsBudget = $eventsBudget;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}

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

    #[ORM\Column(type: 'string', nullable: true)]
    private ?int $accommodationBudget = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?int $restaurationBudget = null;

    #[ORM\Column(type: 'string', nullable: true)]
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

    public function getAccommodationBudget(): ?string
    {
        return $this->accommodationBudget;
    }

    public function setAccommodationBudget(?string $accommodationBudget): self
    {
        $this->accommodationBudget = $accommodationBudget;

        return $this;
    }

    public function getRestaurationBudget(): ?string
    {
        return $this->restaurationBudget;
    }

    public function setRestaurationBudget(?string $restaurationBudget): self
    {
        $this->restaurationBudget = $restaurationBudget;

        return $this;
    }

    public function getEventsBudget(): ?string
    {
        return $this->eventsBudget;
    }

    public function setEventsBudget(?string $eventsBudget): self
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

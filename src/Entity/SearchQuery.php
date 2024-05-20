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
    private ?string $departureLocation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $departureDate = null;

    #[ORM\Column(length: 255)]
    private ?string $arrivalLocation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $arrivalDate = null;

    #[ORM\Column(length: 255)]
    private ?string $preferredTransportation = null;

    #[ORM\ManyToOne(inversedBy: 'searchQueries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartureLocation(): ?string
    {
        return $this->departureLocation;
    }

    public function setDepartureLocation(string $departureLocation): static
    {
        $this->departureLocation = $departureLocation;

        return $this;
    }

    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departureDate;
    }

    public function setDepartureDate(\DateTimeInterface $departureDate): static
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    public function getArrivalLocation(): ?string
    {
        return $this->arrivalLocation;
    }

    public function setArrivalLocation(string $arrivalLocation): static
    {
        $this->arrivalLocation = $arrivalLocation;

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

    public function getPreferredTransportation(): ?string
    {
        return $this->preferredTransportation;
    }

    public function setPreferredTransportation(string $preferredTransportation): static
    {
        $this->preferredTransportation = $preferredTransportation;

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

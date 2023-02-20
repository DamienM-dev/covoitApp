<?php

namespace App\Entity;

use App\Repository\RideRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RideRepository::class)]
class Ride
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getUser", "getRide"])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(["getUser", "getRide"])]
    private ?int $distance = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["getUser", "getRide"])]
    private ?\DateTimeInterface $departure_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["getUser", "getRide"])]
    private ?\DateTimeInterface $arrival_at = null;

    #[ORM\Column]
    #[Groups(["getUser", "getRide"])]
    private ?int $places_available = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["getUser", "getRide"])]
    private ?City $city_departure = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["getUser", "getRide"])]
    private ?City $city_arrival = null;

    #[ORM\OneToMany(mappedBy: 'ride', targetEntity: User::class)]
    private Collection $id_ride_user;

    public function __construct()
    {
        $this->id_ride_user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getDepartureAt(): ?\DateTimeInterface
    {
        return $this->departure_at;
    }

    public function setDepartureAt(\DateTimeInterface $departure_at): self
    {
        $this->departure_at = $departure_at;

        return $this;
    }

    public function getArrivalAt(): ?\DateTimeInterface
    {
        return $this->arrival_at;
    }

    public function setArrivalAt(\DateTimeInterface $arrival_at): self
    {
        $this->arrival_at = $arrival_at;

        return $this;
    }

    public function getPlacesAvailable(): ?int
    {
        return $this->places_available;
    }

    public function setPlacesAvailable(int $places_available): self
    {
        $this->places_available = $places_available;

        return $this;
    }

    public function getCityDeparture(): ?city
    {
        return $this->city_departure;
    }

    public function setCityDeparture(?city $city_departure): self
    {
        $this->city_departure = $city_departure;

        return $this;
    }

    public function getCityArrival(): ?city
    {
        return $this->city_arrival;
    }

    public function setCityArrival(?city $city_arrival): self
    {
        $this->city_arrival = $city_arrival;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getIdRideUser(): Collection
    {
        return $this->id_ride_user;
    }

    public function addIdRideUser(user $idRideUser): self
    {
        if (!$this->id_ride_user->contains($idRideUser)) {
            $this->id_ride_user->add($idRideUser);
            $idRideUser->setRide($this);
        }

        return $this;
    }

    public function removeIdRideUser(user $idRideUser): self
    {
        if ($this->id_ride_user->removeElement($idRideUser)) {
            // set the owning side to null (unless already changed)
            if ($idRideUser->getRide() === $this) {
                $idRideUser->setRide(null);
            }
        }

        return $this;
    }
}

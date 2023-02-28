<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getUser","getConducteur"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
      /**
     * @var string A "Y-m-d H:i:s" formatted value
     */
    // #[Assert\DateTime(message: "le format doit être Y-m-d H:i:s")]
    #[Assert\NotBlank(message: "Vous devez préciser l'heure de départ")]
    #[Groups(["getUser"])]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
       /**
     * @var string A "Y-m-d H:i:s" formatted value
     */
    // #[Assert\DateTime(message: "le format doit être Y-m-d H:i:s")]
    #[Assert\NotBlank(message: "Vous devez préciser l'heure d")]
    #[Groups(["getUser"])]
    private ?\DateTimeInterface $uptated_at = null;

    #[ORM\OneToMany(mappedBy: 'reservation', targetEntity: User::class)]
    private Collection $id_reservation_user;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["getUser","getConducteur"])]
    private ?Ride $id_reservation_ride = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $reservation_from = null;

    public function __construct()
    {
        $this->id_reservation_user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUptatedAt(): ?\DateTimeInterface
    {
        return $this->uptated_at;
    }

    public function setUptatedAt(\DateTimeInterface $uptated_at): self
    {
        $this->uptated_at = $uptated_at;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getIdReservationUser(): Collection
    {
        return $this->id_reservation_user;
    }

    public function getIdReservationRide(): ?ride
    {
        return $this->id_reservation_ride;
    }

    public function setIdReservationRide(?ride $id_reservation_ride): self
    {
        $this->id_reservation_ride = $id_reservation_ride;

        return $this;
    }

    public function getReservationFrom(): ?user
    {
        return $this->reservation_from;
    }

    public function setReservationFrom(?user $reservation_from): self
    {
        $this->reservation_from = $reservation_from;

        return $this;
    }
}

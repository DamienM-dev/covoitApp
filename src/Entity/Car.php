<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getCar"])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(["getCar"])]
    #[Assert\NotBlank(message: "Vous devez préciser l'immatriculation du véhicule")]
    #[Assert\Length(
        min: 3,
        max: 15,
        minMessage: 'L\'immatriculation doit avoir {{ limit }} caractéres minimum',
        maxMessage: 'L\'immatriculation doit avoir {{ limit }} caractéres maximum',
    )]
    #[Assert\Regex('/^[A-Za-z0-9]+$/')]
    private ?string $immatriculation = null;

    #[ORM\Column]
    #[Groups(["getCar"])]
    #[Assert\NotBlank(message: "Vous devez préciser le nombre de places")]
    #[Assert\Length(
        min: 1, 
        max: 7,minMessage: " {{ limit }} place minimum", 
        maxMessage: "{{ limit }} places maximum")]
    private ?int $nbr_places = null;

    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $id_fkuser;

    #[ORM\ManyToOne(cascade:["persist"])]
    private ?Brand $type_of = null;

    public function __construct()
    {
        $this->id_fkuser = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getNbrPlaces(): ?int
    {
        return $this->nbr_places;
    }

    public function setNbrPlaces(int $nbr_places): self
    {
        $this->nbr_places = $nbr_places;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getIdFkuser(): Collection
    {
        return $this->id_fkuser;
    }

    public function addIdFkuser(User $idFkuser): self
    {
        if (!$this->id_fkuser->contains($idFkuser)) {
            $this->id_fkuser->add($idFkuser);
        }

        return $this;
    }

    public function removeIdFkuser(User $idFkuser): self
    {
        $this->id_fkuser->removeElement($idFkuser);

        return $this;
    }

    public function getTypeOf(): ?brand
    {
        return $this->type_of;
    }

    public function setTypeOf(?brand $type_of): self
    {
        $this->type_of = $type_of;

        return $this;
    }

}

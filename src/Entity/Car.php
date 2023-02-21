<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $immatriculation = null;

    #[ORM\Column]
    private ?int $nbr_places = null;

    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $id_fkuser;

    #[ORM\ManyToOne]
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

    public function setImmatriculation(int $immatriculation): self
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

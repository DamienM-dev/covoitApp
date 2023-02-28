<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[Groups(["getRide"])]
    #[Assert\NotBlank(message: "Vous devez préciser le nom de la ville")]
    #[Assert\Length(min: 2, max: 30,minMessage: "le nom doit faire au moins {{ limit }} caractères", maxMessage: "le nom doit faire au maximum {{ limit }} caractéres")]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Vous devez préciser le code postal")]
    #[Assert\Length(min: 5, max: 5,minMessage: "le cp doit faire au moins {{ limit }} caractères", maxMessage: "le cp doit faire au maximum {{ limit }} caractéres")]
    #[Assert\Regex('~^\d{5}$~', message: "Vous devez écrire le code postal au format XXXXX")]
    private ?int $cp = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column]
    private ?float $latitude = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }
}

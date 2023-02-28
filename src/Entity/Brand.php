<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
class Brand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: "Vous devez préciser la marque du véhicule")]
    #[Assert\Length(
        min: 3,
        max: 15,
        minMessage: 'La marque doit avoir {{ limit }} caractéres minimum',
        maxMessage: 'La marque doit avoir {{ limit }} caractéres maximum',
    )]
    private ?string $brand = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }
}

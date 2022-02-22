<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreRepository::class)
 */
class Offre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message=" this field is required ")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity=Abonnement::class, inversedBy="offre")
     * @Assert\NotBlank(message=" this field is required ")
     */
    private $abonnement;
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message=" this field is required ")
     */
    private $duree;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message=" this field is required ")
     */
    private $solde;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message=" this field is required ")
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getSolde(): ?string
    {
        return $this->solde;
    }

    public function setSolde(string $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}

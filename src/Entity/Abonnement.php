<?php

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AbonnementRepository::class)
 */
class Abonnement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="2",max="20",minMessage="champ invalide")
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message=" this field is required ")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(value="today UTC", message="invalid date")
     */
    private $date_final;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message=" this field is required ")
     * @Assert\Email( message = "The email is not a valid email.")
     */
    private $email;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message=" this field is required ")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=8)
     *  @Assert\Length(min="8",max="8",minMessage="champ invalide")
     */
    private $num_tel;

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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFinal(): ?\DateTimeInterface
    {
        return $this->date_final;
    }

    public function setDateFinal(\DateTimeInterface $date_final): self
    {
        $this->date_final = $date_final;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->num_tel;
    }

    public function setNumTel(string $num_tel): self
    {
        $this->num_tel = $num_tel;

        return $this;
    }
}

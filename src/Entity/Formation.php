<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'the name cannot be blank')]
    #[Assert\NotNull(message:'the name cannot be null')]
    #[Assert\Regex(pattern: '/^[a-zA-Z_\s]{4,}$/', message: 'The cours name can only contain letters and numbers.' )]  
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'La date de début ne peut pas être vide.')]
    #[Assert\GreaterThan(value: 'today',message: 'La date de début doit être une date future.' )]
        private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'the name cannot be blank')]
    #[Assert\NotNull(message:'the name cannot be null')]
    #[Assert\Regex(
        pattern: '/^\d+\s*(heures|jours|semaines|mois|années)?$/i',
        message: "La durée doit être formulée comme 'nheures, njours', 'nsemaines', etc."
    )]
    private ?string $Duree = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'the description cannot be blank')]
    #[Assert\NotNull(message:'the description cannot be null')]
    #[Assert\Type(type:'String',message:'the name must be a string')]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Type('float')]
    #[Assert\GreaterThan(0)]
    private ?float $cout = null;

    #[ORM\ManyToMany(targetEntity: Offre::class, mappedBy: 'formations')]
    private Collection $offres;

    public function __construct()
    {
        $this->offres = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->Duree;
    }

    public function setDuree(string $Duree): static
    {
        $this->Duree = $Duree;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCout(): ?float
    {
        return $this->cout;
    }

    public function setCout(float $cout): static
    {
        $this->cout = $cout;

        return $this;
    }

    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres[] = $offre;
            $offre->addFormation($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            $offre->removeFormation($this);
        }

        return $this;
    }

}

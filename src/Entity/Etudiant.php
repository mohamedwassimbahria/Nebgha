<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
class Etudiant extends User
{
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $niveauEtude = null;

    #[ORM\Column(length: 255)]
    private ?string $parcourSuivi = null;

    /**
     * @var Collection<int, Evenement>
     */
    #[ORM\ManyToMany(targetEntity: Evenement::class, mappedBy: 'etudiants')]
    private Collection $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getNiveauEtude(): ?string
    {
        return $this->niveauEtude;
    }

    public function setNiveauEtude(string $niveauEtude): static
    {
        $this->niveauEtude = $niveauEtude;

        return $this;
    }

    public function getParcourSuivi(): ?string
    {
        return $this->parcourSuivi;
    }

    public function setParcourSuivi(string $parcourSuivi): static
    {
        $this->parcourSuivi = $parcourSuivi;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $Evenement): static
    {
        if (!$this->evenements->contains($Evenement)) {
            $this->evenements->add($Evenement);
            $Evenement->addEtudiant($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $Evenement): static
    {
        if ($this->evenements->removeElement($Evenement)) {
            $Evenement->removeEtudiant($this);
        }

        return $this;
    }
}

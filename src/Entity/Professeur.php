<?php

namespace App\Entity;

use App\Repository\ProfesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfesseurRepository::class)]
class Professeur extends User  // Héritage de User
{

    #[ORM\Column(length: 255)]

    private ?string $specialite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateEmbauche = null;
 #[ORM\OneToMany(targetEntity: Evenement::class, mappedBy: 'id_prof')]
    private Collection $evenements;
    #[ORM\OneToMany(targetEntity: Offre::class, mappedBy: 'id_prof')]
    private Collection $offres;


 public function __construct()
 {
     $this->evenements = new ArrayCollection();
     $this->offres = new ArrayCollection();

 }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): static
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getDateEmbauche(): ?\DateTimeInterface
    {
        return $this->DateEmbauche;
    }

    public function setDateEmbauche(\DateTimeInterface $DateEmbauche): static
    {
        $this->DateEmbauche = $DateEmbauche;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): static
    {
      if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->setIdProf($this);
      }

      return $this;
 }

    public function removeEvenement(Evenement $evenement): static
   {
      if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getIdProf() === $this) {
                $evenement->setIdProf(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection<int, Offre>
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): static
    {
      if (!$this->offres->contains($offre)) {
            $this->offres->add($offre);
            $offre->setIdProf(id_prof: $this);
      }

      return $this;
 }

    public function removeOffre(Offre $offre): static
   {
      if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getIdProf() === $this) {
                $offre->setIdProf(null);
            }
        }

        return $this;
    }
}


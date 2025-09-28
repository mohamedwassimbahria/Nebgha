<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Admin extends User  // Héritage de User
{
    #[ORM\Column(length: 255)]
    private ?string $roleAdmin = null;

    #[ORM\Column(length: 255)]
    private ?string $departement = null;
    

        public function getRoleAdmin(): ?string
    {
        return $this->roleAdmin;
    }

    public function setRoleAdmin(string $roleAdmin): static
    {
        $this->roleAdmin = $roleAdmin;
        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): static
    {
        $this->departement = $departement;
        return $this;
    }
 

}


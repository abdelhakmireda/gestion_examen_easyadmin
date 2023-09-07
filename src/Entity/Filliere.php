<?php

namespace App\Entity;

use App\Repository\FilliereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilliereRepository::class)]
class Filliere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'filliere', targetEntity: Etudiant::class)]
    private Collection $etudiants;

    #[ORM\OneToMany(mappedBy: 'filliere', targetEntity: Module::class)]
    private Collection $module;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
        $this->module = new ArrayCollection();
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

    /**
     * @return Collection<int, Etudiant>
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): static
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants->add($etudiant);
            $etudiant->setFilliere($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): static
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getFilliere() === $this) {
                $etudiant->setFilliere(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Module>
     */
    public function getModule(): Collection
    {
        return $this->module;
    }

    public function addModule(Module $module): static
    {
        if (!$this->module->contains($module)) {
            $this->module->add($module);
            $module->setFilliere($this);
        }

        return $this;
    }

    public function removeModule(Module $module): static
    {
        if ($this->module->removeElement($module)) {
            // set the owning side to null (unless already changed)
            if ($module->getFilliere() === $this) {
                $module->setFilliere(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nom ; // Adjust this based on how you want to represent the Professeur object as a string
    }
}

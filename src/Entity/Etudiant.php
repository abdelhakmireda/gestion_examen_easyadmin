<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Filliere;
use App\Entity\Note;


/**
 * @Vich\Uploadable
 */

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
class Etudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $cne = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    /**
     * @Vich\UploadableField(mapping="etudiants", fileNameProperty="photo")
     */
    private ?File $photoFile = null;

    #[ORM\ManyToOne(inversedBy: 'etudiants')]
    private ?Filliere $filliere = null;
    
    #[ORM\ManyToMany(targetEntity:Module::class, inversedBy:"etudiants")]
    private Collection $modules;



    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Note::class, cascade: ['remove'])]
    private Collection $notes;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getCne(): ?string
{
    return $this->cne;
}

public function setCne(?string $cne): static
{
    $this->cne = $cne;

    return $this;
}
  

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }
    
    public function getPhotoFile(): ?File
    {
        return $this->photoFile;
    }

    public function setPhotoFile(?File $photoFile = null ): void
    {
        $this->photoFile = $photoFile;
    }

    public function getFilliere(): ?filliere
    {
        return $this->filliere;
    }

    public function setFilliere(?filliere $filliere): static
    {
        $this->filliere = $filliere;

        return $this;
    }
    /**
 * @return Collection|Module[]
 */
public function getModules(): Collection
{
    return $this->modules;
}

public function addModule(Module $module): self
{
    if (!$this->modules->contains($module)) {
        $this->modules[] = $module;
        $module->addEtudiant($this);
    }

    return $this;
}

public function removeModule(Module $module): self
{
    if ($this->modules->removeElement($module)) {
        $module->removeEtudiant($this);
    }

    return $this;
}

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setEtudiant($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getEtudiant() === $this) {
                $note->setEtudiant(null);
            }
        }

        return $this;
    }
    public function __toString()
{
    return $this->nom; // Remplacez 'nom' par le champ que vous souhaitez afficher comme chaîne
}
}

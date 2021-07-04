<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Evaluation::class, mappedBy="categorie")
     */
    private $idEvalution;

    public function __construct()
    {
        $this->idEvalution = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Evaluation[]
     */
    public function getIdEvalution(): Collection
    {
        return $this->idEvalution;
    }

    public function addIdEvalution(Evaluation $idEvalution): self
    {
        if (!$this->idEvalution->contains($idEvalution)) {
            $this->idEvalution[] = $idEvalution;
            $idEvalution->setCategorie($this);
        }

        return $this;
    }

    public function removeIdEvalution(Evaluation $idEvalution): self
    {
        if ($this->idEvalution->removeElement($idEvalution)) {
            // set the owning side to null (unless already changed)
            if ($idEvalution->getCategorie() === $this) {
                $idEvalution->setCategorie(null);
            }
        }

        return $this;
    }
}

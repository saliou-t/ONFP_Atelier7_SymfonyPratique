<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluationRepository::class)
 */
class Evaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="evaluations")
     */
    private $idApprenant;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="idEvalution")
     */
    private $categorie;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="time", length=15, nullable=true)
     */
    private $heure;

    /**
     * @ORM\Column(type="time", length=15, nullable=true)
     */
    private $duree;

    public function __construct()
    {
        $this->idApprenant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getIdApprenant(): Collection
    {
        return $this->idApprenant;
    }

    public function addIdApprenant(Apprenant $idApprenant): self
    {
        if (!$this->idApprenant->contains($idApprenant)) {
            $this->idApprenant[] = $idApprenant;
        }

        return $this;
    }

    public function removeIdApprenant(Apprenant $idApprenant): self
    {
        $this->idApprenant->removeElement($idApprenant);

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(?\DateTimeInterface $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getDuree(): ?\DateTimeInterface
    {
        return $this->duree;
    }

    public function setDuree(?\DateTimeInterface $duree): self
    {
        $this->duree = $duree;

        return $this;
    }
}

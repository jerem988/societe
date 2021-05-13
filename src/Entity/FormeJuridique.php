<?php

namespace App\Entity;

use App\Repository\FormeJuridiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormeJuridiqueRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class FormeJuridique
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
    private $libelle;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=SocieteList::class, mappedBy="forme_juridique")
     */
    private $societeLists;

    /**
     * @ORM\OneToMany(targetEntity=SocieteListTrace::class, mappedBy="forme_juridique")
     */
    private $societeListTraces;

    public function __construct()
    {
        $this->societeLists = new ArrayCollection();
        $this->societeListTraces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|SocieteList[]
     */
    public function getSocieteLists(): Collection
    {
        return $this->societeLists;
    }

    public function addSocieteList(SocieteList $societeList): self
    {
        if (!$this->societeLists->contains($societeList)) {
            $this->societeLists[] = $societeList;
            $societeList->setFormeJuridique($this);
        }

        return $this;
    }

    public function removeSocieteList(SocieteList $societeList): self
    {
        if ($this->societeLists->removeElement($societeList)) {
            // set the owning side to null (unless already changed)
            if ($societeList->getFormeJuridique() === $this) {
                $societeList->setFormeJuridique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SocieteListTrace[]
     */
    public function getSocieteListTraces(): Collection
    {
        return $this->societeListTraces;
    }

    public function addSocieteListTrace(SocieteListTrace $societeListTrace): self
    {
        if (!$this->societeListTraces->contains($societeListTrace)) {
            $this->societeListTraces[] = $societeListTrace;
            $societeListTrace->setFormeJuridique($this);
        }

        return $this;
    }

    public function removeSocieteListTrace(SocieteListTrace $societeListTrace): self
    {
        if ($this->societeListTraces->removeElement($societeListTrace)) {
            // set the owning side to null (unless already changed)
            if ($societeListTrace->getFormeJuridique() === $this) {
                $societeListTrace->setFormeJuridique(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(new \DateTime('now'));
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }
}

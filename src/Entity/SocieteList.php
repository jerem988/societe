<?php

namespace App\Entity;

use App\Repository\SocieteListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SocieteListRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class SocieteList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $numero_siren;

    /**
     * @ORM\Column(type="date")
     * @Assert\Type("\DateTimeInterface")
     */
    private $date_immatriculation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $capital;

    /**
     * @ORM\ManyToOne(targetEntity=FormeJuridique::class, inversedBy="societeLists")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $forme_juridique;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "Maximum de caractères: 10"
     * )
     */
    private $numero1;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $type_voie1;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $nom_voie1;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $ville1;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "Maximum de caractères: 10"
     * )
     */
    private $cp1;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "Maximum de caractères: 10"
     * )
     */
    private $numero2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_voie2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom_voie2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville2;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "Maximum de caractères: 10"
     * )
     */
    private $cp2;

    public function __construct()
    {
        $this->societeAdresses = new ArrayCollection();
        $this->societeListTraces = new ArrayCollection();
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

    public function getNumeroSiren(): ?string
    {
        return $this->numero_siren;
    }

    public function setNumeroSiren(string $numero_siren): self
    {
        $this->numero_siren = $numero_siren;

        return $this;
    }

    public function getDateImmatriculation(): ?\DateTimeInterface
    {
        return $this->date_immatriculation;
    }

    public function setDateImmatriculation(\DateTimeInterface $date_immatriculation): self
    {
        $this->date_immatriculation = $date_immatriculation;

        return $this;
    }

    public function getCapital(): ?string
    {
        return $this->capital;
    }

    public function setCapital(string $capital): self
    {
        $this->capital = $capital;

        return $this;
    }

    public function getFormeJuridique(): ?formeJuridique
    {
        return $this->forme_juridique;
    }

    public function setFormeJuridique(?formeJuridique $forme_juridique): self
    {
        $this->forme_juridique = $forme_juridique;

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

    public function getNumero1(): ?string
    {
        return $this->numero1;
    }

    public function setNumero1(string $numero1): self
    {
        $this->numero1 = $numero1;

        return $this;
    }

    public function getTypeVoie1(): ?string
    {
        return $this->type_voie1;
    }

    public function setTypeVoie1(string $type_voie1): self
    {
        $this->type_voie1 = $type_voie1;

        return $this;
    }

    public function getNomVoie1(): ?string
    {
        return $this->nom_voie1;
    }

    public function setNomVoie1(string $nom_voie1): self
    {
        $this->nom_voie1 = $nom_voie1;

        return $this;
    }

    public function getVille1(): ?string
    {
        return $this->ville1;
    }

    public function setVille1(string $ville1): self
    {
        $this->ville1 = $ville1;

        return $this;
    }

    public function getCp1(): ?string
    {
        return $this->cp1;
    }

    public function setCp1(string $cp1): self
    {
        $this->cp1 = $cp1;

        return $this;
    }

    public function getNumero2(): ?string
    {
        return $this->numero2;
    }

    public function setNumero2(?string $numero2): self
    {
        $this->numero2 = $numero2;

        return $this;
    }

    public function getTypeVoie2(): ?string
    {
        return $this->type_voie2;
    }

    public function setTypeVoie2(?string $type_voie2): self
    {
        $this->type_voie2 = $type_voie2;

        return $this;
    }

    public function getNomVoie2(): ?string
    {
        return $this->nom_voie2;
    }

    public function setNomVoie2(?string $nom_voie2): self
    {
        $this->nom_voie2 = $nom_voie2;

        return $this;
    }

    public function getVille2(): ?string
    {
        return $this->ville2;
    }

    public function setVille2(?string $ville2): self
    {
        $this->ville2 = $ville2;

        return $this;
    }

    public function getCp2(): ?string
    {
        return $this->cp2;
    }

    public function setCp2(?string $cp2): self
    {
        $this->cp2 = $cp2;

        return $this;
    }
}

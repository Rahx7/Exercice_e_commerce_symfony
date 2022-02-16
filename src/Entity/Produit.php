<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $nom;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'float')]
    private $prix;

    #[ORM\Column(type: 'integer')]
    private $stock;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\File(  mimeTypes:["image/png", "image/jpeg"],
    mimeTypesMessage:"le format de fichier ne correspond pas"
        )]
    private $photo;

    #[ORM\ManyToMany(targetEntity: ContenuPanier::class, mappedBy: 'produits')]
    private $contenuPaniers;

    public function __construct()
    {
        $this->contenuPaniers = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getPhoto() 
    {
        return $this->photo;
    }

    public function setPhoto( $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    #[ORM\PostRemove]
    public function deletPhoto()
    {

        if (file_exists(__DIR__.'/../../public/upload/'. $this->photo)) {
            unlink(__DIR__.'/../../public/upload/'. $this->photo);
        }
        return true;
    }


    /**
     * @return Collection|ContenuPanier[]
     */
    public function getContenuPaniers(): Collection
    {
        return $this->contenuPaniers;
    }

    public function addContenuPanier(ContenuPanier $contenuPanier): self
    {
        if (!$this->contenuPaniers->contains($contenuPanier)) {
            $this->contenuPaniers[] = $contenuPanier;
            $contenuPanier->addProduit($this);
        }

        return $this;
    }

    public function removeContenuPanier(ContenuPanier $contenuPanier): self
    {
        if ($this->contenuPaniers->removeElement($contenuPanier)) {
            $contenuPanier->removeProduit($this);
        }

        return $this;
    }
}

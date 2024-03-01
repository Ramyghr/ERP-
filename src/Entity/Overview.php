<?php

namespace App\Entity;

use App\Repository\OverviewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OverviewRepository::class)]
class Overview
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTime $date = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column]
    private ?float $grand = null;

    #[ORM\Column]
    private ?float $due = null;

    #[ORM\Column(length: 255)]
    private ?string $method = null;

    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'overview')]
    private Collection $Product;

    #[ORM\Column(nullable: true)]
    private ?int $discountPercentage = null;

    #[ORM\Column(nullable: true)]
    private ?float $vat = null;

    #[ORM\Column(nullable: true)]
    private ?float $subAmount = null;

    #[ORM\Column(nullable: true)]
    private ?float $discount = null;

    #[ORM\Column(nullable: true)]
    private ?float $totala = null;

    #[ORM\Column(nullable: true)]
    private ?float $granda = null;

    public function __construct()
    {
        $this->Product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }
    
    public function setDate(?\DateTime $date): static
    {
        $this->date = $date;
    
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getGrand(): ?float
    {
        return $this->grand;
    }

    public function setGrand(float $grand): static
    {
        $this->grand = $grand;

        return $this;
    }

    public function getDue(): ?float
    {
        return $this->due;
    }

    public function setDue(float $due): static
    {
        $this->due = $due;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): static
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduct(): Collection
    {
        return $this->Product;
    }

    public function addProduct(Produit $product): static
    {
        if (!$this->Product->contains($product)) {
            $this->Product->add($product);
            $product->setOverview($this);
        }

        return $this;
    }

    public function removeProduct(Produit $product): static
    {
        if ($this->Product->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getOverview() === $this) {
                $product->setOverview(null);
            }
        }

        return $this;
    }

    public function getDiscountPercentage(): ?int
    {
        return $this->discountPercentage;
    }

    public function setDiscountPercentage(?int $discountPercentage): static
    {
        $this->discountPercentage = $discountPercentage;

        return $this;
    }

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(?float $vat): static
    {
        $this->vat = $vat;

        return $this;
    }

    public function getSubAmount(): ?float
    {
        return $this->subAmount;
    }

    public function setSubAmount(?float $subAmount): static
    {
        $this->subAmount = $subAmount;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getTotala(): ?float
    {
        return $this->totala;
    }

    public function setTotala(float $totala): static
    {
        $this->totala = $totala;

        return $this;
    }

    public function getGranda(): ?float
    {
        return $this->granda;
    }

    public function setGranda(float $granda): static
    {
        $this->granda = $granda;

        return $this;
    }
}

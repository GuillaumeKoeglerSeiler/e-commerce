<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity=Area::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity=Domain::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $domain;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity=GrapeVariety::class, inversedBy="products")
     */
    private $grapeVariety;
    

    public function __construct()
    {
        $this->grapeVariety = new ArrayCollection();
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

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

    public function getYear(): ?\DateTimeInterface
    {
        return $this->year;
    }

    public function setYear(\DateTimeInterface $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getArea(): ?Area
    {
        return $this->area;
    }

    public function setArea(?Area $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getDomain(): ?Domain
    {
        return $this->domain;
    }

    public function setDomain(?Domain $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|GrapeVariety[]
     */
    public function getGrapeVariety(): Collection
    {
        return $this->grapeVariety;
    }

    public function addGrapeVariety(GrapeVariety $grapeVariety): self
    {
        if (!$this->grapeVariety->contains($grapeVariety)) {
            $this->grapeVariety[] = $grapeVariety;
        }

        return $this;
    }

    public function removeGrapeVariety(GrapeVariety $grapeVariety): self
    {
        $this->grapeVariety->removeElement($grapeVariety);

        return $this;
    }

     /**
     * @return Collection|OrderingItem[]
     */
    public function getOrderingItems(): Collection
    {
        return $this->orderingItems;
    }

    public function addOrderingItem(OrderingItem $orderingItem): self
    {
        if (!$this->orderingItems->contains($orderingItem)) {
            $this->orderingItems[] = $orderingItem;
            $orderingItem->setProduct($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderingItem $orderingItem): self
    {
        if ($this->orderingItems->removeElement($orderingItem)) {
            // set the owning side to null (unless already changed)
            if ($orderingItem->getProduct() === $this) {
                $orderingItem->setProduct(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use App\Entity\OrderingItem;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity(repositoryClass=OrderingRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Ordering
{
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_PAID = 'PAID';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status = 'PENDING';

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $orderingedAt;

    /**
     * @ORM\OneToMany(targetEntity=OrderingItem::class, mappedBy="ordering", orphanRemoval=true)
     * @var Collection<OrderingItem>
     */
    private $orderingItems;



    public function __construct()
    {
        $this->orderingItems = new ArrayCollection();
    }

       /**
     * @ORM\PrePersist 
     */
    public function prePersist()
    {
        if (empty($this->orderingedAt)) {
            $this->orderingedAt = new DateTime();
        }
    }
    /**
     * @ORM\PreFlush
     */
    public function preFlush()
    {
        $total = 0;

        foreach ($this->orderingItems as $item) {
            $total += $item->getTotal();
        }
          $this->total = $total;
         
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getTotal(): ?int
    {
        $total = 0;
        foreach($this->orderingItems as $item){
            $total += $item->getTotal();
        }
        return $this->total = $total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOrderingedAt(): ?\DateTimeInterface
    {
        return $this->orderingedAt;
    }

    public function setOrderingedAt(\DateTimeInterface $orderingedAt): self
    {
        $this->orderingedAt = $orderingedAt;

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
            $orderingItem->setOrdering($this);
        }

        return $this;
    }

    public function removeOrderingItem(OrderingItem $orderingItem): self
    {
        if ($this->orderingItems->removeElement($orderingItem)) {
            // set the owning side to null (unless already changed)
            if ($orderingItem->getOrdering() === $this) {
                $orderingItem->setOrdering(null);
            }
        }

        return $this;
    }
}
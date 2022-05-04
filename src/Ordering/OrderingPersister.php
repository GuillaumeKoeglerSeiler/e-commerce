<?php

namespace App\Ordering;

use App\Cart\CartService;
use App\Entity\Ordering;
use App\Entity\OrderingItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class OrderingPersister
{
    protected $security;
    protected $cartservice;
    protected $em;


    public function __construct(Security  $security, CartService $cartService, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->cartService = $cartService;
        $this->em = $em;
    }

    public function storeOrdering(Ordering $ordering)
    {
        $ordering->setUser($this->security->getUser());

        $this->em->persist($ordering);

        foreach ($this->cartService->getDetailCartItem() as $cartItem) {
            $orderingItem = new OrderingItem;
            $orderingItem->setOrdering($ordering)
                ->setProduct($cartItem->product)
                ->setProductName($cartItem->product->getName())
                ->setProductPrice($cartItem->product->getPrice())
                ->setQuantity($cartItem->quantity)
                ->setTotal($cartItem->getTotal());
                $ordering->addOrderingItem($orderingItem);
            $this->em->persist($orderingItem);
    
        }

        $this->em->flush();
    }
}
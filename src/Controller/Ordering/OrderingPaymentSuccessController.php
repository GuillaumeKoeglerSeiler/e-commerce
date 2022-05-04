<?php

namespace App\Controller\Ordering;

use App\Entity\Ordering;
use App\Cart\CartService;
use App\Event\OrderingSuccessEvent;
use App\Repository\OrderingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class OrderingPaymentSuccessController extends AbstractController
{

    /**
     * @Route("/ordering/terminate/{id}", name="ordering_payment_success")
     * @IsGranted("ROLE_USER")
     */
    public function success($id, OrderingRepository $orderingRepository, EntityManagerInterface $em, CartService $cartService, EventDispatcherInterface $dispatcher)
    {
        $ordering = $orderingRepository->find($id);
        if (!$ordering || $ordering && $ordering->getUser() !== $this->getUser() || $ordering && $ordering->getStatus() === ordering::STATUS_PAID) {
            $this->addFlash('error', "la commande n'existe pas");
            return $this->redirectToRoute('ordering_index');
        }

        $ordering->setStatus(ordering::STATUS_PAID);
        $em->flush();

        $cartService->empty();
        $orderingEvent = new OrderingSuccessEvent($ordering);
        $dispatcher->dispatch($orderingEvent, 'ordering.success');

        $this->addFlash('success', "la commande a été payé, vous receverez un mail dans les plus brefs délais lorsque la commande sera traité");
        return $this->redirectToRoute('ordering_index');
    }
}
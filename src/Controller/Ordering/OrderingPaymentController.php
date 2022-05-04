<?php

namespace App\Controller\Ordering;

use App\Entity\Ordering;
use App\Repository\OrderingRepository;
use App\Stripe\StripeService;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderingPaymentController extends AbstractController
{

    /**
     * @Route("/ordering/pay/{id}", name="ordering_payement_form")
     * @IsGranted("ROLE_USER")
     */
    public function showCardForm($id, OrderingRepository $orderingRepository, StripeService $stripeService)
    {
        $ordering = $orderingRepository->find($id);

        if (!$ordering || $ordering && $ordering->getUser() !== $this->getUser() || $ordering && $ordering->getStatus() === ordering::STATUS_PAID) {

            return $this->redirectToRoute('cart_index');
        }
        $intent = $stripeService->getPaymentIntent($ordering);
        return $this->render('ordering/payment.html.twig', [

            'clientSecret' => $intent->client_secret,
            'ordering' => $ordering,
            'stripePublicKey'=> $stripeService->getPublicKey()

        ]);
    }
}
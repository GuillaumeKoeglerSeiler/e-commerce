<?php

namespace App\Controller\Ordering;


use App\Entity\Ordering;
use App\Cart\CartService;
use App\Form\CartConfirmationType;
use App\Ordering\OrderingPersister;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class OrderingConfirmationController extends AbstractController
{


    protected $cartService;
    protected $em;
    protected $persister;

    public function __construct(CartService $cartService, EntityManagerInterface $em, OrderingPersister $persister)
    {
        $this->cartService = $cartService;
        $this->em = $em;
        $this->persister = $persister;
    }

    /**
     * @Route("/ordering/confirm", name="ordering_confirm")
     * @IsGranted("ROLE_USER", message ="Vous devez être connecté pour effectuer une commande")
     */
    public function confirm(Request $request)
    {
        $form = $this->createForm(CartConfirmationType::class);

        $form->handleRequest($request);
        if (!$form->isSubmitted()) {
            $this->addFlash('error', 'vous devez remplir le formulaire de confirmation');
            return $this->redirectToRoute('cart_index');
        }

        $user = $this->getUser();

        $cartItems = $this->cartService->getDetailCartItem();

        if (count($cartItems) === 0) {

            $this->addFlash('error', 'Vous ne pouvez pas valider une commande avec un panier vide');

            return $this->redirectToRoute('cart_index');
        }
        /** @var Ordering  */
        $ordering = $form->getData();

        $this->persister->storeOrdering($ordering);

        return $this->redirectToRoute('ordering_payement_form', [
            'id' => $ordering->getId()

        ]);
    }
}
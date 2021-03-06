<?php

namespace App\Controller\Ordering;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class OrderingsListController extends AbstractController
{

    /**
     * @Route("/orderings", name="ordering_index")
     * @IsGranted("ROLE_USER", message="vous devez être connecté pour acceder à vos commandes")
     */
    public function index()
    {
        /** @var User */
        $user = $this->getUser();

        return $this->render('ordering/index.html.twig', [
            'orderings' => $user->getOrderings()
        ]);
    }
}
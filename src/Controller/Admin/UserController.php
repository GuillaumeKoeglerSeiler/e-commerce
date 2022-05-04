<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\OrderingRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/user", name="admin_user_")
 */

class UserController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAll()
        ]);
    }
    /**
     * @Route("/orderings/{id}", name="orderings")
     */
    public function userOrderings(UserRepository $userRepository, $id): Response
    {
        return $this->render('admin/user/orderings.html.twig',[
            'users' => $userRepository->findById($id)
        ]);
    }

            /**
     * @Route("/delete/{id}/user", name="delete")
     */
    public function deleteUser(ManagerRegistry $em, User $user): Response {
        $em->getManager()->remove($user);
        $em->getManager()->flush();
        $this->addFlash("delete", "Le membre à bien été supprimé");
        return $this->redirectToRoute('admin_home');
        
    }
}
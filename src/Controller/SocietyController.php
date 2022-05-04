<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SocietyController extends AbstractController
{
    /**
     * @Route("/society/who", name="society_who")
     */
    public function who(): Response
    {
        return $this->render('society/who.html.twig', []);
    }
    /**
     * @Route("/society/cgus", name="society_cgus")
     */
    public function cgus(): Response 
    {
        return $this->render('society/cgus.html.twig', []);
    }
}

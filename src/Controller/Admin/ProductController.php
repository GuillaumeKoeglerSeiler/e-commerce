<?php

namespace App\Controller\Admin;

use App\Entity\Domain;
use App\Entity\Product;
use App\Form\DomainType;
use App\Form\ProductType;
use App\Entity\GrapeVariety;
use App\Form\GrapeVarietyType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/product", name="admin_product_")
 */

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('admin/product/index.html.twig', [
            'products' => $productRepository->findAll()
        ]);
    }

    /**
     * @Route("/add/product", name="add_product")
     */
    public function addProduct(Request $request)
    {
        $product = new Product;

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('admin_home');
        }
        return $this->render('admin/product/addProduct.html.twig', [
            'formProduct' => $form->createView()
        ]);
    }
     /**
     * @Route("/edit/{id}", name="edit")
     */
    public function editProduct(Product $product, Request $request)
    {

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('admin_home');
        }
        return $this->render('admin/product/addProduct.html.twig', [
            'formProduct' => $form->createView()
        ]);
    }

        /**
     * @Route("/delete/{id}/delete", name="delete")
     */
    public function deleteProduct(ManagerRegistry $em, Product $product): Response {
        $em->getManager()->remove($product);
        $em->getManager()->flush();
        $this->addFlash("delete", "Le produit à bien été supprimé");
        return $this->redirectToRoute('admin_home');
        
    }


     /**
     * @Route("/add/domain", name="add_domain")
     */
    public function addDomain(Request $request)
    {
        $domain = new Domain;

        $form = $this->createForm(DomainType::class, $domain);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($domain);
            $em->flush();

            return $this->redirectToRoute('admin_home');
        }
        return $this->render('admin/product/addDomain.html.twig', [
            'formDomain' => $form->createView()
        ]);
    }
     /**
     * @Route("/add/grapeVariety", name="add_grapeVariety")
     */
    public function addGrapeVariety(Request $request)
    {
        $grapeVariety = new GrapeVariety;

        $form = $this->createForm(GrapeVarietyType::class, $grapeVariety);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($grapeVariety);
            $em->flush();

            return $this->redirectToRoute('admin_home');
        }
        return $this->render('admin/product/addGrapeVariety.html.twig', [
            'formGrapeVariety' => $form->createView()
        ]);
    }
}

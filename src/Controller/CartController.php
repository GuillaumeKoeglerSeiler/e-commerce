<?php

namespace App\Controller;

use App\Entity\Product;
use App\Cart\CartService;
use App\Form\CartConfirmationType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
     * @Route("/cart", name="cart_")
     * Raccourci pour que les liens commencent par cart_
     */
class CartController extends AbstractController
{
     /**
     * @var ProductRepository
     */
    protected $productRepository;
    /**
     * @var CartService
     */
    protected $cartservice;
    public function __construct(ProductRepository $productRepository, CartService $cartService)
    {
        $this->productRepository = $productRepository;
        $this->cartService = $cartService;
    }
   
    /**
     * @Route("/add/{id}", name="add")
     * CETTE FONCTION SERT A AJOUTER UN PRODUIT AU PANIER
     */ 
        public function add($id, Request $request)
        {
    
            $entityManager = $this->getDoctrine()->getManager();
            $product = $this->productRepository->find($id);
            if (!$product) {
    
                throw $this->createNotFoundException("le produit $id n'éxiste pas");
            }
            $stock = $product->getStock();
            if($stock <= 0){
                $this->addFlash('error', "le produit n'est plus disponible");
                return $this->redirectToRoute('product');
            }
            else{
                // si on ajoute un produit au panier, le stock de ce produit diminue de 1
                $product->setStock($stock -1);
                $entityManager->flush();
                $this->cartService->add($id);
            }
    
            $this->addFlash('success', "le produit a bien été ajouté au panier");
            //Si l'élement à la mention returnToCart il reviendra sur le panier
            if ($request->query->get('returnToCart')) {
                return $this->redirectToRoute('cart_index');
            }
            //Si l'élement à la mention returToHome il reviendra sur la page d'accueil
            if ($request->query->get('returnToHome')) {
                return $this->redirectToRoute('product');
            }
            //Sans mention spécifique, il renvoi sur le panier
            return $this->redirectToRoute('cart_index', []);
        }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove($id){
        
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->productRepository->find($id);
        if (!$product) {

            throw $this->createNotFoundException("le produit $id n'éxiste pas");
        }
        $stock = $product->getStock();
        // si on supprime un produit du panier, le stock de ce produit augmente de 1
        $product->setStock($stock +1);
        $entityManager->flush();
        $this->cartService->decrement($id);

        $this->addFlash('success', "le produit a bien été enlevé au panier");
        return $this->redirectToRoute("cart_index");
    }

        /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id)
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            throw $this->createNotFoundException("Le produit $id demandé n'éxiste pas et ne peut être supprimé !");
        }
        $this->cartService->remove($id);

        $this->addFlash('success', "le produit a bien été supprimé du panier");

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete", name="delete_all")
     */
    public function deleteAll(){

        $this->cartService->delete();

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $dataOrder = $this->cartService->getDetailCartItem();
        $total = $this->cartService->getTotal();
        return $this->render('cart/index.html.twig', [
            'total' => $total,
            'dataOrder' => $dataOrder,
        ]);
    }

    /**
     * @Route("/delivery", name="delivery")
     */
    public function delivery()
    {
        $form = $this->createForm(CartConfirmationType::class);
        $dataOrder = $this->cartService->getDetailCartItem();
        $total = $this->cartService->getTotal();
        return $this->render('delivery/index.html.twig', [
            'total' => $total,
            'dataOrder' => $dataOrder,
            'confirmationForm'=>$form->createView()

        ]);
    }
}

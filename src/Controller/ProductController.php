<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\SearchWineType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product")
     */
    public function index(ProductRepository $productRepository, Request $request): Response
    {

        return $this->render('product/index.html.twig', [
            'products' => $productRepository->getPaginatedProduct((int)$request->query->get('page', 1)),
            'totalPages' => $productRepository->countPages()
        ]);
    }
       /**
     * @Route("/search", name="search" )
     */
    public function searchWine(Request $request, ProductRepository $productRepository){
        
        $products = [];
        //on créé le formulaire
        $search = $this->createForm(SearchWineType::class);
        $search->handleRequest($request);
        // on cherche à savoir si le formulaire est envoyé et valide
        //afin de récupérer les données et les traiter
        if($search->isSubmitted() && $search->isValid()){
            $criteria = $search->getData();
            $products = $productRepository->searchWine($criteria);
        }
        return $this->render('product/search.html.twig', [
            'search_form' => $search->createView(),
            'products' => $products
        ]); 
    }
    /**
     * @Route("/product/{id}", name="product_show")
     */
    public function productShow(Product $product) : Response {
      
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}

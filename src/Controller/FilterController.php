<?php

namespace App\Controller;

use App\Entity\Area;
use App\Entity\Type;
use App\Entity\Domain;
use App\Entity\Product;
use App\Entity\GrapeVariety;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilterController extends AbstractController
{
    /**
     * @Route("/type", name="type")
     */
    public function indexType(): Response
    {
        $types = $this->getDoctrine()
            ->getRepository(Type::class) //on appelle le repository de la classe Product
            ->findAll();

        return $this->render('filter/type/index.html.twig', [
            'types' => $types,
        ]);
    }

    /**
     * @Route("/area", name="area")
     */
    public function indexArea(): Response
    {
        $areas = $this->getDoctrine()
            ->getRepository(Area::class) //on appelle le repository de la classe Product
            ->findAll();

        return $this->render('filter/area/index.html.twig', [
            'areas' => $areas,
        ]);
    }

    /**
     * @Route("/grape_variety", name="grape_variety")
     */
    public function indexGrapeVariety(): Response
    {
        $grapeVarietys = $this->getDoctrine()
            ->getRepository(GrapeVariety::class) //on appelle le repository de la classe Product
            ->findAll();

        return $this->render('filter/grapeVariety/index.html.twig', [
            'grapeVarietys' => $grapeVarietys,
        ]);
    }

      /**
     * @Route("/domain", name="domain")
     */
    public function indexDomain(): Response
    {
        $domains = $this->getDoctrine()
            ->getRepository(Domain::class) //on appelle le repository de la classe Product
            ->findAll();

        return $this->render('filter/domain/index.html.twig', [
            'domains' => $domains,
        ]);
    }

     /**
     * @Route("/type/{id}", name="type_show")
     */
    public function showType(Type $type): Response{
        return $this->render('filter/type/show.html.twig', [
            'type' => $type
        ]);
    }

    /**
     * @Route("/area/{id}", name="area_show")
     */
    public function showArea(Area $area): Response{
        return $this->render('filter/area/show.html.twig', [
            'area' => $area
        ]);
    }

    /**
     * @Route("/domain/{id}", name="domain_show")
     */
    public function showDomain(Domain $domain): Response{
        return $this->render('filter/domain/show.html.twig', [
            'domain' => $domain,
        ]);
    }

     /**
     * @Route("/grapeVariety/{id}", name="grapeVariety_show")
     */
    public function showGrapeVariety(GrapeVariety $grape): Response{
        return $this->render('filter/grapeVariety/show.html.twig', [
            'grape' => $grape
        ]);
    }
    /**
     * @Route("/price", name="price")
     */
    public function price(ProductRepository $productRepository, Request $request): Response
    {
        $min = $request->get('min') ?? null;
        $max = $request->get('max') ?? null;
        $products = $productRepository->searchPrice($min, $max);

        return $this->render('filter/price/index.html.twig', [
            'products' => $products,
            'min' => $min,
            'max' => $max,
        ]);
    }
    /**
     * @Route("/note", name="note")
     */
    public function note(ProductRepository $productRepository, Request $request): Response
    {
        $min = $request->get('min') ?? null;
        $max = $request->get('max') ?? null;
        $products = $productRepository->searchNote($min, $max);

        return $this->render('filter/note/index.html.twig', [
            'products' => $products,
            'min' => $min,
            'max' => $max,
        ]);
    }
}

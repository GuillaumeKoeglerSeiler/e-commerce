<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
/**
 * @return Product[] returns an array of Product objects by search
 * Cette fonction permet de récupérer les critères suivants : type, région, prix min et max
 * afin que l'utilisateur qui à une idée assez précise de ce qu'il souhaite puisse
 * seléctionner plusieurs critères. Ils ne sont pas tous mis afin d'éviter de l'embrouiller
 * ou de tomber trop de fois sur le résultat "aucune recherche", ce qui risque de le décourager
 */
    public function searchWine($criteria){
        return $this->createQueryBuilder('p')
            ->leftJoin('p.type', 'type')
            ->where('type.name = :typeName')
            ->setParameter('typeName', $criteria['type']->getName())
            ->leftJoin('p.area', 'area')
            ->andWhere('area.name = :areaName')
            ->setParameter('areaName', $criteria['area']->getName())
            ->andWhere('p.price > :minimumPrice')
            ->setParameter('minimumPrice', $criteria['minimumPrice'])
            ->andWhere('p.price < :maximumPrice')
            ->setParameter('maximumPrice', $criteria['maximumPrice'])
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * fonction permettant de faire plusieurs pages de produits pour ne pas
     * scroller à l'infini
     */
    public function getPaginatedProduct(int $page){
        $queryBuilder = $this->createQueryBuilder('p')
            //id dans l'order décroissant pour que les derniers produits soient
            //en premières pages sur le site
            ->orderBy('p.id', 'desc')
            //on demande à avoir 12 résultat par page, soit 3 lignes de 4 produits
            ->setFirstResult($page * 12 - 12)
            ->setMaxResults(12)
        ;

        return $queryBuilder->getQuery()->getResult();
    }
    /**
     * fonction permettant de créer autant de page qu'il faut par rapport
     * au nombre d'articles
     */
    public function countPages(){
        return $this->createQueryBuilder('p')
        ->select('COUNT(p.id)')    
        ->getQuery()
            //renvoi une valeur scalaire unique
            ->getSingleScalarResult();
    }

    public function searchPrice($min, $max){
        $qb = $this->createQueryBuilder('p');
        if($min){
            $qb->where('p.price >= :min')->setParameter(':min', $min);
        }
        if($max){
            $qb->andWhere('p.price <= :max')->setParameter(':max', $max);
        }
        return $qb->getQuery()->getResult();
    }

    public function searchNote($min, $max){
        $qb = $this->createQueryBuilder('p');
        if($min){
            $qb->where('p.note >= :min')->setParameter(':min', $min);
        }
        if($max){
            $qb->andWhere('p.note <= :max')->setParameter(':max', $max);
        }
        return $qb->getQuery()->getResult();
    }



    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

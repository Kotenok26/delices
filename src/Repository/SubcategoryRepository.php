<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Subcategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Subcategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subcategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subcategory[]    findAll()
 * @method Subcategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubcategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subcategory::class);
    }

    /**
     * @return Subcategory[] Returns an array of Subcategory objects
    */

    public function findByCategory(Category $category): array
    {
        return $this->createQueryBuilder('s')
            ->where(':category MEMBER OF s.category')
            ->setParameter('val', $category)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Subcategory
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
//    public function findOneByCategory($category): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.category = :category')
//            ->setParameter('category', $category)
//            ->getQuery()
//            ->getOneOrNullResult()
//            ;
//    }
}

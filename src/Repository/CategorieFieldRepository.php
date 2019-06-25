<?php

namespace Sofia\GenFormBundle\Repository;

use Sofia\GenFormBundle\Entity\CategorieField;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CategorieField|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieField|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieField[]    findAll()
 * @method CategorieField[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieFieldRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CategorieField::class);
    }

    // /**
    //  * @return CategorieField[] Returns an array of CategorieField objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategorieField
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

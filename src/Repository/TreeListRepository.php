<?php

namespace App\Repository;

use App\Entity\TreeList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TreeList|null find($id, $lockMode = null, $lockVersion = null)
 * @method TreeList|null findOneBy(array $criteria, array $orderBy = null)
 * @method TreeList[]    findAll()
 * @method TreeList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TreeListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TreeList::class);
    }

    // /**
    //  * @return TreeList[] Returns an array of TreeList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TreeList
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

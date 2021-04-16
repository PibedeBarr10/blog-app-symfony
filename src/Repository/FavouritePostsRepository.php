<?php

namespace App\Repository;

use App\Entity\FavouritePosts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FavouritePosts|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavouritePosts|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavouritePosts[]    findAll()
 * @method FavouritePosts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavouritePostsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavouritePosts::class);
    }

    // /**
    //  * @return FavouritePosts[] Returns an array of FavouritePosts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FavouritePosts
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

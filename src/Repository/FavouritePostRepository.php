<?php

namespace App\Repository;

use App\Entity\FavouritePost;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FavouritePost|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavouritePost|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavouritePost[]    findAll()
 * @method FavouritePost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavouritePostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavouritePost::class);
    }

    public function save(FavouritePost $favouritePost): void
    {
        $this->_em->persist($favouritePost);
        $this->_em->flush();
    }

    public function remove(FavouritePost $favouritePost): void
    {
        $this->_em->remove($favouritePost);
        $this->_em->flush();
    }

    public function favouriteUserPosts(User $user): array
    {
        $addedToFav = $this->findBy([
            'user' => $user
        ]);

        $favouritePosts = [];
        foreach ($addedToFav as $post) {
            if ($post->getPost()->getVisible()) {
                $favouritePosts[] = $post->getPost();
            }
        }

        return $favouritePosts;
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

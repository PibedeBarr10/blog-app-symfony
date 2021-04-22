<?php

namespace App\Repository;

use App\Entity\Like;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Like|null find($id, $lockMode = null, $lockVersion = null)
 * @method Like|null findOneBy(array $criteria, array $orderBy = null)
 * @method Like[]    findAll()
 * @method Like[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Like::class);
    }

    public function save(Like $like): void
    {
        $this->_em->persist($like);
        $this->_em->flush();
    }

    public function remove(Like $like): void
    {
        $this->_em->remove($like);
        $this->_em->flush();
    }

    public function isLikedByUser(User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('l')
            ->from('App:Like', 'l')
            ->where('l.user = :user')
            ->setParameter('user', $user)
        ;

        return $qb->getQuery()->getResult();
    }

    public function postsLikedByUser(User $user): array
    {
        $likes = $this->isLikedByUser($user);

        $likedPosts = [];
        foreach ($likes as $like) {
            $likedPosts[] = $like->getPost();
        }

        return $likedPosts;
    }

    // /**
    //  * @return Like[] Returns an array of Like objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Like
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

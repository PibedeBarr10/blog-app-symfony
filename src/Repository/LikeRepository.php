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

    public function postsLikedByUser(User $user): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from('App:Like', 'l')
            ->innerJoin('App:Post', 'p', 'WITH', 'p.id = l.post')
            ->where('l.user = :user')
            ->setParameter('user', $user)
        ;

        return $qb->getQuery()->getResult();
    }

    public function removeAllByPostId(Post $post) {
        $likes = $this->findBy([
            'post' => $post
        ]);

        foreach ($likes as $like) {
            $this->remove($like);
        }
    }
}

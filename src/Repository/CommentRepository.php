<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function add(Comment $comment, bool $flush = true): void {
        $this->_em->persist($comment);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(Comment $comment, bool $flush = true): void {
        $this->_em->remove($comment);
        if ($flush) {
            $this->_em->flush();
        }
    }

    //pour avoir les derniers commentaires
    public function latestComments(int $limit = 4){
        return $this->createQueryBuilder('lc')
            ->orderBy('lc.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }
}

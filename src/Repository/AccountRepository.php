<?php

namespace App\Repository;

use App\Entity\Account;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }

    public function add(Account $account, bool $flush = true): void {
        $this->_em->persist($account);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(Account $account, bool $flush = true): void {
        $this->_em->remove($account);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getOneAccountBySlug($slug){
        return $this->createQueryBuilder('a')
        ->select('a','lib', 'g')
        ->join('a.libraries', 'lib')
        ->join('lib.game', 'g')
        ->where('a.slug = :slug')
        ->setParameter('slug', $slug)
        ->getQuery()
        ->getSingleResult()
        ;
    }

    
}

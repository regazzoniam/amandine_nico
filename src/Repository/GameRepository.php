<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Library;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function add(Game $game, bool $flush = true): void {
        $this->_em->persist($game);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(Game $game, bool $flush = true): void {
        $this->_em->remove($game);
        if ($flush) {
            $this->_em->flush();
        }
    }

    //pour avoir les dernières sorties
    public function latestGames(){
        return $this->createQueryBuilder('lg')
            ->select('lg')
            ->orderBy('lg.publishedAt', 'DESC')
            ->setMaxResults(9)
            ->getQuery()
            ->getResult()
            ;

    }
    
    //pour avoir les jeux les plus joués
    //Join à vérifier (cf use)
    public function getMostPlayedGames(int $limit = 9){
        return $this->createQueryBuilder('g')
            ->join(Library::class,'lib', Join::WITH,'lib.game = g')
            ->groupBy('g.name')
            ->orderBy('SUM(lib.gameTime)','DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }

    //pour avoir les jeux les plus achetés
    public function getMostBoughtGames(int $limit = 9){
        return $this->createQueryBuilder('g')
            ->join(Library::class,'lib', Join::WITH,'lib.game = g')
            ->groupBy('g.name')
            ->orderBy('COUNT(lib.gameTime)','DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getGameWithRelations(string $slug, bool $fully = true): ?Game {
        $qb = $this->createQueryBuilder('g')
            ->leftJoin('g.comments', 'cmts')
            ->leftJoin('cmts.account', 'a')
        ;

        if ($fully) {
            $qb->select('g','c','gr', 'p','cmts','a')
                ->join('g.countries', 'c')
                ->join('g.genres','gr')
                ->leftJoin('g.publisher', 'p')
            ;
        } else {
            $qb->select ('g','cmts', 'a');
        }

        return $qb->where('g.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getRelatedGames(Game $game)
    {
        return $this->createQueryBuilder('g')
            ->select('g')
            ->join('g.genres','genres')
            ->where('genres IN(:genres)')
            ->setParameter('genres', $game->getGenres())
            ->andWhere('g != :currentGame')
            ->setParameter('currentGame', $game)
            ->orderBy('g.publishedAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}

<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public $queryBuilder = null;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getQueryBuilder() : QueryBuilder
    {
        return $this->queryBuilder ?? $this->createQueryBuilder('a')
            ->leftJoin('a.tags', 't')
            ->orderBy('a.create_date', 'DESC');
    }

    public function findDefault(): ArticleRepository
    {
        $this->queryBuilder = $this->getQueryBuilder();
        return $this;
    }

    public function findByMonthYear($month, $year)
    {
        $fromTime = new \DateTime($year . '-' . $month . '-01');
        $toTime = new \DateTime($fromTime->format('Y-m-d') . ' first day of next month');
        $this->queryBuilder
                    ->andWhere('a.create_date >= :fromTime')
                    ->andWhere('a.create_date < :toTime')
                    ->setParameter('fromTime', $fromTime)
                    ->setParameter('toTime', $toTime);
    }

    public function findByTags(Array $tags)
    {
        $this->queryBuilder
                    ->andWhere('t.name IN (:tags)')
                    ->setParameter('tags', $tags);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

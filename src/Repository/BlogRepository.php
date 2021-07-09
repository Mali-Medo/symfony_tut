<?php

namespace App\Repository;

use App\Entity\Blog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Blog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blog[]    findAll()
 * @method Blog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blog::class);
    }

     /**
      * @return Blog[] Returns an array of Blog objects
      */

    public function findAllPostedOrderedByNewest(): array
    {
        //b blogs
        //t tags
        return $this->addIsPostedQueryBuilder()
            ->leftJoin('b.tags', 't')
            ->addSelect('t')
            ->orderBy('b.postedAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    private function addIsPostedQueryBuilder(QueryBuilder $qb = null): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder($qb)
            ->andWhere('b.postedAt IS NOT NULL');
    }

    private function getOrCreateQueryBuilder(QueryBuilder $qb = null): QueryBuilder
    {
        return $qb ?: $this->createQueryBuilder('b');
    }

    public static function createNonDeletedCriteria(): Criteria
    {
        return Criteria::create()
            ->andWhere(Criteria::expr()->eq('isDeleted', false))
            ->orderBy(['createdAt' => 'DESC'])
        ;
    }

    /*
    public function findOneBySomeField($value): ?Blog
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllOrderedDQL()
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.comments', 'c')
            ->leftJoin('b.tags', 't')
            ->addOrderBy('b.title', 'DESC')
            ->getQuery()
            ->execute();
    }
    public function getWithSearchDQL(?string $term)
    {
//        $query = $em->createQuery('SELECT b FROM App\Entity\Blog b
//                                       LEFT JOIN b.comments c
//                                       LEFT JOIN b.tags t
//                                       LEFT JOIN b.author a
//                                       WHERE b.title LIKE :term
//                                       ');
//        $query->setParameter('term', '%'.$term.'%');
//        return $query->getResult(); // array of User objects

        return $this->createQueryBuilder('b')
            ->leftJoin('b.comments', 'c')
            ->leftJoin('b.tags', 't')
            ->leftJoin('b.author', 'a')
            ->andWhere('b.title LIKE :term')
            ->setParameter('term', '%'.$term.'%')
            ->getQuery()
            ->execute();

    }
}

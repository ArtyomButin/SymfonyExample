<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    /**
     * @param int $page
     * @param int $perPage
     * @return QueryBuilder
     */
    public function getUsersWithPagination(int $page, int $perPage): QueryBuilder
    {
        return $this->createQueryBuilder('u')
            ->select('u')
            ->from($this->getClassName(), 'u')
            ->orderBy('u.id', 'DESC')
            ->setFirstResult($perPage * $page)
            ->setMaxResults($perPage)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    /**
     * @return Users[] Returns an array of Users objects
     *
     */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneBySomeField($value): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

<?php

namespace App\Repository\Catalogo;

use App\Entity\Estructura\Cedis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cedis>
 *
 * @method Cedis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cedis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cedis[]    findAll()
 * @method Cedis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CedisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cedis::class);
    }
  
    public function add(Cedis $entity, bool $flush = true): Cedis
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }
  
    public function edit(Cedis $entity, bool $flush = true): Cedis
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Cedis $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}

<?php

namespace App\Repository\Catalogo;

use App\Entity\Estructura\Territorio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Territorio>
 *
 * @method Territorio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Territorio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Territorio[]    findAll()
 * @method Territorio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TerritorioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Territorio::class);
    }
  
    public function add(Territorio $entity, bool $flush = true): Territorio
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }
  
    public function edit(Territorio $entity, bool $flush = true): Territorio
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Territorio $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}

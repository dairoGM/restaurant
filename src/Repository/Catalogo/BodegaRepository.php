<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\Bodega;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bodega>
 *
 * @method Bodega|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bodega|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bodega[]    findAll()
 * @method Bodega[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BodegaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bodega::class);
    }
  
    public function add(Bodega $entity, bool $flush = true): Bodega
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }
  
    public function edit(Bodega $entity, bool $flush = true): Bodega
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Bodega $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}

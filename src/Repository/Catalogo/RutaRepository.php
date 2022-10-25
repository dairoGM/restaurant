<?php

namespace App\Repository\Catalogo;

use App\Entity\Estructura\Ruta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ruta>
 *
 * @method Ruta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ruta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ruta[]    findAll()
 * @method Ruta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RutaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ruta::class);
    }
  
    public function add(Ruta $entity, bool $flush = true): Ruta
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }
  
    public function edit(Ruta $entity, bool $flush = true): Ruta
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Ruta $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}

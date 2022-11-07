<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\Mecanica;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mecanica>
 *
 * @method Mecanica|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mecanica|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mecanica[]    findAll()
 * @method Mecanica[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MecanicaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mecanica::class);
    }
  
    public function add(Mecanica $entity, bool $flush = true): Mecanica
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }
  
    public function edit(Mecanica $entity, bool $flush = true): Mecanica
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Mecanica $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}

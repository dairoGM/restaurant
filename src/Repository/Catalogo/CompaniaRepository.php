<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\Compania;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Compania>
 *
 * @method Compania|null find($id, $lockMode = null, $lockVersion = null)
 * @method Compania|null findOneBy(array $criteria, array $orderBy = null)
 * @method Compania[]    findAll()
 * @method Compania[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompaniaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Compania::class);
    }
  
    public function add(Compania $entity, bool $flush = true): Compania
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }
  
    public function edit(Compania $entity, bool $flush = true): Compania
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Compania $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}

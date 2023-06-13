<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\Caja;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Caja>
 *
 * @method Caja|null find($id, $lockMode = null, $lockVersion = null)
 * @method Caja|null findOneBy(array $criteria, array $orderBy = null)
 * @method Caja[]    findAll()
 * @method Caja[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CajaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Caja::class);
    }

    public function add(Caja $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Caja $entity, bool $flush = true): Caja
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Caja $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

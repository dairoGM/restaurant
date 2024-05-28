<?php

namespace App\Repository\Restaurant;

use App\Entity\Restaurant\ReservacionMesa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReservacionMesa>
 *
 * @method ReservacionMesa|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservacionMesa|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservacionMesa[]    findAll()
 * @method ReservacionMesa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservacionMesaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservacionMesa::class);
    }

    public function add(ReservacionMesa $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(ReservacionMesa $entity, bool $flush = true): ReservacionMesa
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(ReservacionMesa $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }



}
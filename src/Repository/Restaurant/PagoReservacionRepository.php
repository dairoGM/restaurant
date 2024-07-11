<?php

namespace App\Repository\Restaurant;

use App\Entity\Restaurant\PagoReservacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PagoReservacion>
 *
 * @method PagoReservacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method PagoReservacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method PagoReservacion[]    findAll()
 * @method PagoReservacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PagoReservacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PagoReservacion::class);
    }

    public function add(PagoReservacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(PagoReservacion $entity, bool $flush = true): PagoReservacion
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(PagoReservacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


}

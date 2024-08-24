<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\TipoReservacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TipoReservacion>
 *
 * @method TipoReservacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoReservacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoReservacion[]    findAll()
 * @method TipoReservacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoReservacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoReservacion::class);
    }

    public function add(TipoReservacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(TipoReservacion $entity, bool $flush = true): TipoReservacion
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(TipoReservacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function listarTiposReservacion()
    {
        $query = $this->createQueryBuilder('qb')
            ->select('qb.id, 
                        qb.nombre, 
                        qb.activo')
            ->orderBy('qb.nombre');
        return $query->getQuery()->getResult();
    }
}

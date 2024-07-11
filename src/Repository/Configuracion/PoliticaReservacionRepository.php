<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\PoliticaReservacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PoliticaReservacion>
 *
 * @method PoliticaReservacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method PoliticaReservacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method PoliticaReservacion[]    findAll()
 * @method PoliticaReservacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoliticaReservacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PoliticaReservacion::class);
    }

    public function add(PoliticaReservacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(PoliticaReservacion $entity, bool $flush = true): PoliticaReservacion
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(PoliticaReservacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarPoliticaReservacion()
    {
        $qb = $this->createQueryBuilder('qb')
            ->select('qb.id, 
                        qb.descripcion');
        $qb->orderBy('qb.nombre');
        $resul = $qb->getQuery()->getResult();

        return $resul;
    }
}

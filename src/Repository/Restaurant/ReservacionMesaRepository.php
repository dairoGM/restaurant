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


    public function getCantidadReservaciones($fecha, $espacioId = null)
    {
        $query = $this->createQueryBuilder('qb')
            ->select(
                "sum(qb.cantidadPersona) as total"
            )
            ->innerJoin('qb.espacio', 'e');
        if (!empty($espacioId)) {
            $query->where("e.id = $espacioId");
        }
        $query->andWhere('qb.fechaReservacion LIKE :val');
        $query->setParameter('val', '%' . $fecha . '%');

        $result = $query->getQuery()->getResult(1);
        return $result[0]['total'] ?? 0;
    }

    public function getReservaciones($email = null, $prereserva = null)
    {
        $query = $this->createQueryBuilder('qb')
            ->select(
                "qb.id,
                 qb.nombreCompleto, 
                 qb.celular,  
                 qb.ticket, 
                 qb.cantidadPersona,
                 qb.estado,                 
                 qb.descripcion,                 
                 qb.fechaReservacion, 
                 qb.numeroTransferencia, 
                 qb.politicaCancelacion, 
                 qb.horaInicio, 
                 mp.nombre as nombreMetodoPago,
                 qb.horaFin,                  
                 e.nombreCorto as nombreCorteEspacio, 
                 p.email"
            )
            ->join('qb.espacio', 'e')
            ->join('qb.metodoPago', 'mp')
            ->join('qb.perfil', 'p');
        if (!empty($email)) {
            $query->where("p.email = '$email'");
        }
        if (!empty($prereserva)) {
            $query->andWhere("qb.estado = 'Prereserva'");
        }
        $query->orderBy('qb.id', 'desc');
        $result = $query->getQuery()->getResult();
        return $result;
    }

    public function listarReservacionesPrereserva($email = null)
    {
        $query = $this->createQueryBuilder('qb')
            ->select(
                "qb.id,
                 qb.nombreCompleto, 
                 qb.celular,  
                 qb.ticket, 
                 qb.cantidadPersona,
                 qb.estado,                 
                 qb.descripcion,                 
                 qb.fechaReservacion, 
                 qb.numeroTransferencia, 
                 qb.politicaCancelacion, 
                 qb.horaInicio, 
                 mp.nombre as nombreMetodoPago,
                 qb.horaFin,                  
                 e.nombreCorto as nombreCorteEspacio, 
                 p.email"
            )
            ->join('qb.espacio', 'e')
            ->join('qb.metodoPago', 'mp')
            ->join('qb.perfil', 'p');
        $query->where("p.email = '$email'");
        $query->andWhere("qb.estado = 'Prereserva'");
        $query->orderBy('qb.id', 'desc');
        $result = $query->getQuery()->getResult();
        return $result;
    }


}

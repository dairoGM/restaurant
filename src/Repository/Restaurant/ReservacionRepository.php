<?php

namespace App\Repository\Restaurant;

use App\Entity\Restaurant\Reservacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservacion>
 *
 * @method Reservacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservacion[]    findAll()
 * @method Reservacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservacion::class);
    }

    public function add(Reservacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Reservacion $entity, bool $flush = true): Reservacion
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Reservacion $entity, bool $flush = false): void
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
        $query->andWhere('qb.fechaReservacion LIKE :val')->setParameter('val', '%' . $fecha . '%');

        $result = $query->getQuery()->getResult(1);
        return $result[0]['total'] ?? 0;
    }

    public function getReservaciones($email = null)
    {
        $where = "qb.estado <> 'Prereserva'";
        $query = $this->createQueryBuilder('qb')
            ->select(
                "qb.id,
                 qb.nombreCompleto, 
                 qb.celular,  
                 qb.ticket, 
                 qb.tipo,
                 case when qb.tipo='por_mesa' then qb.cantidadPersona else  qb.cantidad end as cantidad,
                 qb.estado,                 
                 qb.descripcion,                 
                 qb.fechaReservacion, 
                 qb.numeroTransferencia, 
                 qb.politicaCancelacion, 
                 qb.horaInicio, 
                 mp.nombre as nombreMetodoPago,
                 qb.horaFin,                  
                 e.nombreCorto as nombreCortoEspacio, 
                 e.id as idEspacio,
                 pl.nombre as nombrePlato, 
                 pl.id as idPlato,
                 p.email"
            )
            ->leftJoin('qb.espacio', 'e')
            ->leftJoin('qb.plato', 'pl')
            ->leftJoin('qb.metodoPago', 'mp')
            ->join('qb.perfil', 'p');
        if (!empty($email)) {
            $where .= " AND p.email = '$email'";
        }
        $query->where($where);
        $query->orderBy('qb.id', 'desc');
        $result = $query->getQuery()->getResult();
        return $result;
    }

    public function getReservacionesCanceladas($email = null)
    {
        $query = $this->createQueryBuilder('qb')
            ->select(
                "qb.id,
                 qb.nombreCompleto, 
                 qb.celular,  
                 qb.ticket, 
                 qb.tipo,
                 case when qb.tipo='por_mesa' then qb.cantidadPersona else  qb.cantidad end as cantidad,
                 qb.estado,                 
                 qb.descripcion,                 
                 qb.fechaReservacion, 
                 qb.numeroTransferencia, 
                 qb.politicaCancelacion, 
                 qb.horaInicio, 
                 mp.nombre as nombreMetodoPago,
                 qb.horaFin,                  
                 e.nombreCorto as nombreCortoEspacio, 
                 e.id as idEspacio,
                 pl.nombre as nombrePlato, 
                 pl.id as idPlato,
                 p.email"
            )
            ->leftJoin('qb.espacio', 'e')
            ->leftJoin('qb.plato', 'pl')
            ->leftJoin('qb.metodoPago', 'mp')
            ->join('qb.perfil', 'p')
            ->where("qb.estado = 'Cancelada'");
        if (!empty($email)) {
            $query->where("p.email = '$email'");
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
                 qb.tipo,
                 case when qb.tipo='por_mesa' then qb.cantidadPersona else  qb.cantidad end as cantidad,
                 qb.estado,                 
                 qb.descripcion,                 
                 qb.fechaReservacion, 
                 qb.numeroTransferencia, 
                 qb.politicaCancelacion, 
                 qb.horaInicio, 
                 mp.nombre as nombreMetodoPago,
                 qb.horaFin,                  
                 e.nombreCorto as nombreCortoEspacio, 
                 e.id as idEspacio,
                 pl.nombre as nombrePlato, 
                 pl.id as idPlato,
                 p.email"
            )
            ->leftJoin('qb.espacio', 'e')
            ->leftJoin('qb.metodoPago', 'mp')
            ->leftJoin('qb.perfil', 'p');
        $query->where("p.email = '$email'");
        $query->andWhere("qb.estado = 'Prereserva'");
        $query->orderBy('qb.id', 'desc');
        $result = $query->getQuery()->getResult();
        return $result;
    }


    public function listarReservacionesPrereservaMesa($email, $espacio = null)
    {
        $query = $this->createQueryBuilder('qb')
            ->select(
                "qb.id,
                 qb.nombreCompleto, 
                 qb.celular,  
                 qb.ticket, 
                 qb.tipo,
                 case when qb.tipo='por_mesa' then qb.cantidadPersona else  qb.cantidad end as cantidad,
                 qb.estado,                 
                 qb.descripcion,                 
                 qb.fechaReservacion, 
                 qb.numeroTransferencia, 
                 qb.politicaCancelacion, 
                 qb.horaInicio, 
                 mp.nombre as nombreMetodoPago,
                 qb.horaFin,                  
                 e.nombreCorto as nombreCortoEspacio, 
                 e.id as idEspacio,
                 pl.nombre as nombrePlato, 
                 pl.id as idPlato,
                 p.email"
            )
            ->join('qb.espacio', 'e')
            ->leftJoin('qb.metodoPago', 'mp')
            ->leftJoin('qb.perfil', 'p')
            ->where("p.email = '$email' and e.id is not null");
        $query->andWhere("qb.estado = 'Prereserva'");
        if (!empty($espacio)) {
            $query->andWhere("e.id = '$espacio'");
        }
        $query->orderBy('qb.id', 'desc');
        $result = $query->getQuery()->getResult();
        return $result;
    }


}

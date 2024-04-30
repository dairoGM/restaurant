<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\Evento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evento>
 *
 * @method Evento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evento[]    findAll()
 * @method Evento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evento::class);
    }

    public function add(Evento $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Evento $entity, bool $flush = true): Evento
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Evento $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarEventos()
    {
        $qb = $this->createQueryBuilder('qb')
            ->select('qb.id, 
                        qb.nombre, 
                        qb.activo, 
                        qb.fecha, 
                        qb.orden, 
                        qb.locacion, 
                        qb.telefonoAuspiciador, 
                        qb.cantidadParticipantes, 
                        qb.gestionarBuffet, 
                        qb.ambientacion, 
                        qb.descripcion, 
                        te.nombre as nombreTipoEvento, 
                        te.id as idTipoEvento')
            ->innerJoin('qb.tipoEvento', 'te');

        $qb->orderBy('qb.orden');
        $resul = $qb->getQuery()->getResult();

        return $resul;
    }
}

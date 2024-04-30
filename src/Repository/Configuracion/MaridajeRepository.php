<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\Maridaje;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Maridaje>
 *
 * @method Maridaje|null find($id, $lockMode = null, $lockVersion = null)
 * @method Maridaje|null findOneBy(array $criteria, array $orderBy = null)
 * @method Maridaje[]    findAll()
 * @method Maridaje[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaridajeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Maridaje::class);
    }

    public function add(Maridaje $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Maridaje $entity, bool $flush = true): Maridaje
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Maridaje $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarMaridajes()
    {
        $qb = $this->createQueryBuilder('qb')
            ->select('qb.id, 
                        qb.nombre, 
                        qb.activo, 
                        qb.fecha,                        
                        qb.locacion,                         
                        qb.cantidadParticipantes,                       
                        qb.descripcion, 
                        tm.nombre as nombreTipoMaridaje, 
                        tm.id as idTipoMaridaje')
            ->innerJoin('qb.tipoMaridaje', 'tm');

        $qb->orderBy('qb.nombre');
        $resul = $qb->getQuery()->getResult();

        return $resul;
    }
}

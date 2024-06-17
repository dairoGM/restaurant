<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\Tiempo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tiempo>
 *
 * @method Tiempo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tiempo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tiempo[]    findAll()
 * @method Tiempo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TiempoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tiempo::class);
    }

    public function add(Tiempo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Tiempo $entity, bool $flush = true): Tiempo
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Tiempo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarTiempo()
    {
        $qb = $this->createQueryBuilder('qb')
            ->select('qb.id, 
                        qb.nombre, 
                        qb.activo, 
                        qb.fecha,                        
                        qb.cantidadPlantosPersonas,                         
                        qb.cantidadTragosPersonas,                         
                        qb.cantidadParticipantes,                       
                        qb.descripcion, 
                        tc.nombre as nombreTipoTiempo, 
                        tc.id as idTipoTiempo')
            ->innerJoin('qb.tipoTiempo', 'tc');

        $qb->orderBy('qb.nombre');
        $resul = $qb->getQuery()->getResult();

        return $resul;
    }
}

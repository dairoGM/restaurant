<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\Sobre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sobre>
 *
 * @method Sobre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sobre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sobre[]    findAll()
 * @method Sobre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SobreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sobre::class);
    }

    public function add(Sobre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Sobre $entity, bool $flush = true): Sobre
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Sobre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarSobre()
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
                        tc.nombre as nombreTipoSobre, 
                        tc.id as idTipoSobre')
            ->innerJoin('qb.tipoSobre', 'tc');

        $qb->orderBy('qb.nombre');
        $resul = $qb->getQuery()->getResult();

        return $resul;
    }
}

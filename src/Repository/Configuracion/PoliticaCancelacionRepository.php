<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\PoliticaCancelacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PoliticaCancelacion>
 *
 * @method PoliticaCancelacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method PoliticaCancelacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method PoliticaCancelacion[]    findAll()
 * @method PoliticaCancelacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoliticaCancelacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PoliticaCancelacion::class);
    }

    public function add(PoliticaCancelacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(PoliticaCancelacion $entity, bool $flush = true): PoliticaCancelacion
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(PoliticaCancelacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarPoliticaCancelacion()
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
                        tc.nombre as nombreTipoPoliticaCancelacion, 
                        tc.id as idTipoPoliticaCancelacion')
            ->innerJoin('qb.tipoPoliticaCancelacion', 'tc');

        $qb->orderBy('qb.nombre');
        $resul = $qb->getQuery()->getResult();

        return $resul;
    }
}

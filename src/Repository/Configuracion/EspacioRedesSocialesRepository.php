<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\EspacioRedesSociales;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EspacioRedesSociales>
 *
 * @method EspacioRedesSociales|null find($id, $lockMode = null, $lockVersion = null)
 * @method EspacioRedesSociales|null findOneBy(array $criteria, array $orderBy = null)
 * @method EspacioRedesSociales[]    findAll()
 * @method EspacioRedesSociales[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EspacioRedesSocialesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EspacioRedesSociales::class);
    }

    public function add(EspacioRedesSociales $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(EspacioRedesSociales $entity, bool $flush = true): EspacioRedesSociales
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(EspacioRedesSociales $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarEspacioRedesSociales()
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
                        tc.nombre as nombreTipoEspacioRedesSociales, 
                        tc.id as idTipoEspacioRedesSociales')
            ->innerJoin('qb.tipoEspacioRedesSociales', 'tc');

        $qb->orderBy('qb.nombre');
        $resul = $qb->getQuery()->getResult();

        return $resul;
    }
}

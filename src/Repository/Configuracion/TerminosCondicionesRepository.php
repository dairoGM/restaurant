<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\TerminosCondiciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TerminosCondiciones>
 *
 * @method TerminosCondiciones|null find($id, $lockMode = null, $lockVersion = null)
 * @method TerminosCondiciones|null findOneBy(array $criteria, array $orderBy = null)
 * @method TerminosCondiciones[]    findAll()
 * @method TerminosCondiciones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TerminosCondicionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TerminosCondiciones::class);
    }

    public function add(TerminosCondiciones $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(TerminosCondiciones $entity, bool $flush = true): TerminosCondiciones
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(TerminosCondiciones $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarTerminosCondiciones($filters = [], $orderBy = [], $limit = null)
    {
        $query = $this->createQueryBuilder('qb')
            ->select('qb.id, 
                        qb.nombre, 
                        qb.activo, 
                        qb.fecha,                        
                        qb.cantidadPlantosPersonas,                         
                        qb.cantidadTragosPersonas,                         
                        qb.cantidadParticipantes,                       
                        qb.descripcion, 
                        tc.nombre as nombreTipoTerminosCondiciones, 
                        tc.id as idTipoTerminosCondiciones')
            ->innerJoin('qb.tipoTerminosCondiciones', 'tc');
        if (!is_null($limit)) {
            $query->setMaxResults($limit);
        }
        if (is_array($filters)) {
            foreach ($filters as $key => $value) {
                $query->andWhere("qb.$key = '$value'");
            }
        }
        if (count($orderBy) == 0) {
            $query->orderBy('qb.nombre', 'ASC');
        } else {
            foreach ($orderBy as $key => $value) {
                $query->addOrderBy("qb.$key", $value);
            }
        }
//        echo '<pre>';
//        print_r($query->getQuery()->getSQL());
//        die;
        return $query->getQuery()->getResult(1);
    }

}

<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\Catering;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Catering>
 *
 * @method Catering|null find($id, $lockMode = null, $lockVersion = null)
 * @method Catering|null findOneBy(array $criteria, array $orderBy = null)
 * @method Catering[]    findAll()
 * @method Catering[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CateringRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Catering::class);
    }

    public function add(Catering $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Catering $entity, bool $flush = true): Catering
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Catering $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarCatering($filters = [], $orderBy = [], $limit = null)
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
                        tc.nombre as nombreTipoCatering, 
                        tc.id as idTipoCatering')
            ->innerJoin('qb.tipoCatering', 'tc');
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

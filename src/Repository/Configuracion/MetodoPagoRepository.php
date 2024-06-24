<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\MetodoPago;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MetodoPago>
 *
 * @method MetodoPago|null find($id, $lockMode = null, $lockVersion = null)
 * @method MetodoPago|null findOneBy(array $criteria, array $orderBy = null)
 * @method MetodoPago[]    findAll()
 * @method MetodoPago[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MetodoPagoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MetodoPago::class);
    }

    public function add(MetodoPago $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(MetodoPago $entity, bool $flush = true): MetodoPago
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(MetodoPago $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function listarMetodosPago($filters = [], $orderBy = [], $limit = null)
    {
        $query = $this->createQueryBuilder('qb')
            ->select(
                "qb.id, 
                        qb.nombre,
                         t.nombre as nombreTipoMetodoPago,
                         tm.nombre as nombreTipoMoneda"
            )
            ->join('qb.tipoMetodoPago', 't')
            ->join('qb.tipoMoneda', 'tm');
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

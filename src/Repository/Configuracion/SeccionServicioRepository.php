<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\SeccionServicio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SeccionServicio>
 *
 * @method SeccionServicio|null find($id, $lockMode = null, $lockVersion = null)
 * @method SeccionServicio|null findOneBy(array $criteria, array $orderBy = null)
 * @method SeccionServicio[]    findAll()
 * @method SeccionServicio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeccionServicioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SeccionServicio::class);
    }

    public function add(SeccionServicio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(SeccionServicio $entity, bool $flush = true): SeccionServicio
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(SeccionServicio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarSeccionServicio($filters = [], $orderBy = [], $limit = null)
    {
        $query = $this->createQueryBuilder('qb')
            ->select(
                " 
                        qb.nombre,
                        qb.descripcion, 
                        qb.imagen  
                        "
            )
            ->join('qb.servicio', 's');
        if (!is_null($limit)) {
            $query->setMaxResults($limit);
        }
        if (is_array($filters)) {
            foreach ($filters as $key => $value) {
                $query->andWhere("$key = '$value'");
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

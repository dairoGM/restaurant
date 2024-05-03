<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\ConocenosRedesSociales;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConocenosRedesSociales>
 *
 * @method ConocenosRedesSociales|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConocenosRedesSociales|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConocenosRedesSociales[]    findAll()
 * @method ConocenosRedesSociales[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConocenosRedesSocialesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConocenosRedesSociales::class);
    }

    public function add(ConocenosRedesSociales $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(ConocenosRedesSociales $entity, bool $flush = true): ConocenosRedesSociales
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(ConocenosRedesSociales $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function listarRedesSocialesEspacios($filters = [], $orderBy = [], $limit = null)
    {
        $query = $this->createQueryBuilder('qb')
            ->select(
                "rs.nombre, 
                        qb.enlace 
                        "
            )
        ->join('qb.conocenos', 'c')
        ->join('qb.redSocial', 'rs');
        if (!is_null($limit)) {
            $query->setMaxResults($limit);
        }
        if (is_array($filters)) {
            foreach ($filters as $key => $value) {
                $query->andWhere("$key = '$value'");
            }
        }
        if (count($orderBy) == 0) {
            $query->orderBy('rs.nombre', 'ASC');
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

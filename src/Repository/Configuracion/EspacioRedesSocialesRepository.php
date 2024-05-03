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


    public function listarRedesSocialesEspacios($filters = [], $orderBy = [], $limit = null)
    {
        $query = $this->createQueryBuilder('qb')
            ->select(
                "rs.nombre, 
                        qb.enlace 
                        "
            )
        ->join('qb.espacio', 'e')
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

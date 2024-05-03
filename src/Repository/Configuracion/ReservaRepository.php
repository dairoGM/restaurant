<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\Reserva;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reserva>
 *
 * @method Reserva|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reserva|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reserva[]    findAll()
 * @method Reserva[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reserva::class);
    }

    public function add(Reserva $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Reserva $entity, bool $flush = true): Reserva
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Reserva $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarItemReserva($filters = [], $orderBy = [], $limit = null)
    {
        $query = $this->createQueryBuilder('qb')
            ->select(
                "qb.id, 
                        qb.nombre, 
                        qb.enlace, 
                        qb.activo "
            );
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

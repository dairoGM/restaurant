<?php

namespace App\Repository\Restaurant;

use App\Entity\Restaurant\Contactenos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contactenos>
 *
 * @method Contactenos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contactenos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contactenos[]    findAll()
 * @method Contactenos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactenosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contactenos::class);
    }

    public function add(Contactenos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Contactenos $entity, bool $flush = true): Contactenos
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Contactenos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function listarContactenos($filters = [], $orderBy = [], $limit = null)
    {
        $query = $this->createQueryBuilder('qb')
            ->select(
                "qb.id,  
                DateFormat(qb.creado, 'DD/MM/YYYY HH24:mi:ss') as creado,
                DateFormat(qb.creado, 'DD/MM/YYYY HH24:mi:ss') as actualizado,
                qb.nombre,
                qb.mensaje,
                qb.correo"
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
            $query->orderBy('qb.id', 'DESC');
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

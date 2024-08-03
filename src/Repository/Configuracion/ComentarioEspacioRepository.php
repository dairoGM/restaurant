<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\ComentarioEspacio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ComentarioEspacio>
 *
 * @method ComentarioEspacio|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComentarioEspacio|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComentarioEspacio[]    findAll()
 * @method ComentarioEspacio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComentarioEspacioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComentarioEspacio::class);
    }

    public function add(ComentarioEspacio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(ComentarioEspacio $entity, bool $flush = true): ComentarioEspacio
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(ComentarioEspacio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarComentariosEspacios($filters = [], $orderBy = [], $limit = null)
    {
        $query = $this->createQueryBuilder('qb')
            ->select(
                " 
                        qb.nombre,
                        qb.comentario,
                        qb.evaluacion, 
                        qb.imagen,
                        qb.url,
                        qb.creado 
                        "
            )
            ->join('qb.espacio', 'e');
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

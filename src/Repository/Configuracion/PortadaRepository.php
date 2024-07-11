<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\Portada;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Portada>
 *
 * @method Portada|null find($id, $lockMode = null, $lockVersion = null)
 * @method Portada|null findOneBy(array $criteria, array $orderBy = null)
 * @method Portada[]    findAll()
 * @method Portada[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortadaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Portada::class);
    }

    public function add(Portada $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Portada $entity, bool $flush = true): Portada
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Portada $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarPortadas($filters = [], $orderBy = [], $limit = null)
    {
        $query = $this->createQueryBuilder('qb')
            ->select('qb.id,                        
                        qb.activo,                                           
                        qb.publico,                                           
                        qb.descripcion,
                        qb.tituloImagen,
                        qb.descripcionImagen,
                        qb.tituloImagen2,
                        qb.descripcionImagen2,
                        qb.tituloImagen3,
                        qb.descripcionImagen3,
                        qb.tituloImagen4,
                        qb.descripcionImagen4,
                         qb.imagen,
                         qb.imagen2,
                         qb.imagen3,
                         qb.imagen4,
                         qb.imagenFooter
                         ');
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

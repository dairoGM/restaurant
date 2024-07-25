<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\Servicio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Servicio>
 *
 * @method Servicio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Servicio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Servicio[]    findAll()
 * @method Servicio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Servicio::class);
    }

    public function add(Servicio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Servicio $entity, bool $flush = true): Servicio
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Servicio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarServicios($filters = [], $orderBy = [], $limit = null)
    {
        $query = $this->createQueryBuilder('qb')
            ->select('qb.id, 
                        qb.nombreCorto, 
                        qb.nombreLargo, 
                        qb.orden,                                           
                        qb.activo,                                           
                        qb.telefonoAuspiciador,                                           
                        qb.cantidadParticipantes,                                           
                        qb.locacion,                                           
                        qb.gestionarBuffet,                                           
                        qb.ambientacion,                                           
                        qb.cantidadPlantosPersonas,                                           
                        qb.cantidadTragosPersonas,                                           
                        qb.publico,                                           
                        qb.descripcion,
                         qb.imagenPortada, 
                         qb.imagenMenu, 
                         qb.imagenDetallada,
                         ts.id as idTipoServicio,
                         ts.nombre as nombreTipoServicio
                         ')
            ->leftJoin('qb.tipoServicio', 'ts');
        if (!is_null($limit)) {
            $query->setMaxResults($limit);
        }
        if (is_array($filters)) {
            foreach ($filters as $key => $value) {
                $query->andWhere("qb.$key = '$value'");
            }
        }
        $query->orderBy('qb.orden', 'DESC');

//        echo '<pre>';
//        print_r($query->getQuery()->getSQL());
//        die;
        return $query->getQuery()->getResult(1);
    }
}

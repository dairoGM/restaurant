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

    public function listarServiciosPublicos()
    {
        $qb = $this->createQueryBuilder('qb')
            ->select('qb.id, 
                        qb.nombreCorto, 
                        qb.nombreLargo, 
                        qb.orden,                                           
                        qb.activo,                                           
                        qb.publico,                                           
                        qb.descripcion,
                         qb.imagenPortada, 
                         qb.imagenDetallada
                         ')
            ->where("qb.publico = true");
        $qb->orderBy('qb.orden');
        $resul = $qb->getQuery()->getResult();
        return $resul;
    }
}

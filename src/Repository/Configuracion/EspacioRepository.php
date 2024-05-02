<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\Espacio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Espacio>
 *
 * @method Espacio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Espacio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Espacio[]    findAll()
 * @method Espacio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EspacioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Espacio::class);
    }

    public function add(Espacio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Espacio $entity, bool $flush = true): Espacio
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Espacio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarEspaciosPublicos()
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

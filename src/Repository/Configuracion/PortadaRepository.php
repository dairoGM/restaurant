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

    public function listarPortadas()
    {
        $qb = $this->createQueryBuilder('qb')
            ->select('qb.id,                        
                        qb.activo,                                           
                        qb.publico,                                           
                        qb.descripcion,
                         qb.imagen
                         ')
            ->where("qb.publico = true");
        $qb->orderBy('qb.id');
        $resul = $qb->getQuery()->getResult();
        return $resul;
    }
}

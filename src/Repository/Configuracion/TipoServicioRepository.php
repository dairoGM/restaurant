<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\TipoServicio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TipoServicio>
 *
 * @method TipoServicio|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoServicio|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoServicio[]    findAll()
 * @method TipoServicio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoServicioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoServicio::class);
    }

    public function add(TipoServicio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(TipoServicio $entity, bool $flush = true): TipoServicio
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(TipoServicio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

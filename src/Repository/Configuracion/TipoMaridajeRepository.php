<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\TipoMaridaje;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TipoMaridaje>
 *
 * @method TipoMaridaje|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoMaridaje|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoMaridaje[]    findAll()
 * @method TipoMaridaje[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoMaridajeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoMaridaje::class);
    }

    public function add(TipoMaridaje $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(TipoMaridaje $entity, bool $flush = true): TipoMaridaje
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(TipoMaridaje $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

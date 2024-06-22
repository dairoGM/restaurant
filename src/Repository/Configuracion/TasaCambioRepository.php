<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\TasaCambio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TasaCambio>
 *
 * @method TasaCambio|null find($id, $lockMode = null, $lockVersion = null)
 * @method TasaCambio|null findOneBy(array $criteria, array $orderBy = null)
 * @method TasaCambio[]    findAll()
 * @method TasaCambio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TasaCambioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TasaCambio::class);
    }

    public function add(TasaCambio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(TasaCambio $entity, bool $flush = true): TasaCambio
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(TasaCambio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
